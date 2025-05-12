<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfileController;

// Главная страница
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Аутентификация
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Профиль пользователя (общий)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
 
// Репетиторы
Route::middleware(['auth'])->prefix('tutor')->name('tutor.')->group(function () {
    // Дашборд репетитора
    Route::get('/dashboard', [TutorController::class, 'dashboard'])->name('dashboard');
    
    // Профиль репетитора
    Route::get('/profile', [TutorController::class, 'showProfileForm'])->name('profile');
    Route::post('/profile', [TutorController::class, 'saveProfile'])->name('profile.save');
});

// Ученики
Route::middleware(['auth', 'student'])->prefix('student')->name('student.')->group(function () {
    // Поиск репетиторов
    Route::get('/tutors', [StudentController::class, 'index'])->name('tutors.index');
    Route::get('/tutors/{tutor}', [StudentController::class, 'show'])->name('tutors.show');
    
    // Взаимодействие с репетиторами
    Route::post('/tutors/{tutor}/contact', [StudentController::class, 'contact'])->name('tutors.contact');
    Route::post('/tutors/{tutor}/review', [StudentController::class, 'leaveReview'])->name('tutors.review');
});

// Публичные маршруты (без аутентификации)
Route::get('/tutors/{tutor}', [StudentController::class, 'show'])->name('tutors.public.show');