<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TutorProfile;
use App\Models\Subject;
use App\Models\Education;
use Illuminate\Support\Facades\Auth;

class TutorController extends Controller
{
    public function dashboard()
    {
        $tutor = Auth::user()->tutorProfile;
        $reviews = $tutor->reviews()->with('student')->latest()->take(5)->get();
        
        return view('tutor.dashboard', compact('tutor', 'reviews'));
    }

    public function showProfileForm()
    {
        
        $tutor = Auth::user()->tutorProfile;
        $subjects = Subject::all();
        $educations = $tutor ? $tutor->educations : collect();

        return view('tutor.profile', compact('tutor', 'subjects', 'educations'));
    }

    public function saveProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'about' => 'required|string|max:2000',
            'experience_years' => 'required|integer|min:0',
            'hourly_rate' => 'required|numeric|min:0',
            'education_level' => 'required|string',
            'video_presentation' => 'nullable|url',
            'subjects' => 'sometimes|required_without:new_subjects|array',
            'subjects.*' => 'sometimes|integer|exists:subjects,id',
            'new_subjects' => 'sometimes|required_without:subjects|array',
            'new_subjects.*' => 'sometimes|string|distinct|min:2',
            'educations' => 'nullable|array',
            //'educations.*.institution' => 'required_with:educations|string',
            //'educations.*.degree' => 'required_with:educations|string',
            //'educations.*.specialization' => 'required_with:educations|string',
            //'educations.*.year_graduated' => 'required_with:educations|integer',
        ]);

        $tutorProfile = TutorProfile::updateOrCreate(
            ['user_id' => $user->id],
            $request->only([
                'about', 
                'experience_years', 
                'hourly_rate', 
                'education_level', 
                'video_presentation'
            ])
        );
        $newSubjectsNames = $request->input('new_subjects', []);
        $newSubjectsIds = [];
        foreach ($newSubjectsNames as $name) {
            $subject = Subject::firstOrCreate(['name' => $name]);
            $newSubjectsIds[] = $subject->id;
        }
        $existingSubjectsIds = $request->input('subjects', []);
        $existingSubjectsIds = array_filter($existingSubjectsIds, 'is_numeric');

        $allSubjectIds = array_merge($existingSubjectsIds, $newSubjectsIds);

        // Синхронизация предметов
        //$tutorProfile->subjects()->sync($request->subjects);
        $tutorProfile->subjects()->sync($allSubjectIds);
        //exit;
        // Обновление образования
        if ($request->has('educations')) {
            $tutorProfile->educations()->delete();
            foreach ($request->educations as $education) {
                $tutorProfile->educations()->create($education);
            }
        }

        return redirect()->route('tutor.dashboard')->with('success', 'Профиль успешно сохранен');
    }
}