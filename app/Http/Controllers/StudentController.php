<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TutorProfile;
use App\Models\Subject;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = TutorProfile::query()->with(['user', 'subjects', 'reviews'])
            ->where('is_approved', true);

        // Фильтрация по предмету
        if ($request->has('subject')) {
            $query->whereHas('subjects', function($q) use ($request) {
                $q->where('id', $request->subject);
            });
        }

        // Фильтрация по цене
        if ($request->has('price_from')) {
            $query->where('hourly_rate', '>=', $request->price_from);
        }

        if ($request->has('price_to')) {
            $query->where('hourly_rate', '<=', $request->price_to);
        }

        // Фильтрация по опыту
        if ($request->has('experience')) {
            $query->where('experience_years', '>=', $request->experience);
        }

        // Фильтрация по уровню образования
        if ($request->has('education_level')) {
            $query->where('education_level', $request->education_level);
        }

        // Сортировка
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('hourly_rate', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('hourly_rate', 'desc');
                    break;
                case 'rating':
                    $query->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'desc');
                    break;
                case 'experience':
                    $query->orderBy('experience_years', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $tutors = $query->paginate(10);
        $subjects = Subject::all();

        return view('student.tutors.index', compact('tutors', 'subjects'));
    }

    public function show($id)
    {
        $tutor = TutorProfile::with(['user', 'subjects', 'educations', 'reviews.user'])
            ->where('is_approved', true)
            ->findOrFail($id);

        $alreadyReviewed = false;
        if (Auth::check()) {
            $alreadyReviewed = Review::where('tutor_id', $tutor->user_id)
                ->where('student_id', Auth::id())
                ->exists();
        }

        return view('student.tutors.show', compact('tutor', 'alreadyReviewed'));
    }

    public function contact($id, Request $request)
    {
        $tutor = TutorProfile::findOrFail($id);
        $student = Auth::user();
        
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Здесь должна быть логика отправки сообщения репетитору
        // Например, отправка email или сохранение в базу данных
        
        return back()->with('success', 'Сообщение отправлено репетитору');
    }

    public function leaveReview($id, Request $request)
    {
        $tutor = TutorProfile::findOrFail($id);
        
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:1000',
        ]);

        // Проверяем, не оставлял ли уже ученик отзыв этому репетитору
        $existingReview = Review::where('tutor_id', $tutor->user_id)
            ->where('student_id', Auth::id())
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Вы уже оставляли отзыв этому репетитору');
        }

        Review::create([
            'tutor_id' => $tutor->user_id,
            'student_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Отзыв успешно добавлен');
    }
}