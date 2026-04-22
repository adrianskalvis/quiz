<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizesController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Redirect old /dashboard to /quizes so Breeze's post-login redirect still works
Route::redirect('/dashboard', '/quizes')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/quizes',                        [QuizesController::class, 'index'])      ->name('quizes');
    Route::get('/quizes/leaderboard',            [QuizesController::class, 'leaderboard'])->name('leaderboard');
    Route::get('/quizes/scores',                 [QuizesController::class, 'scores'])     ->name('scores');
    Route::get('/quizes/{topic:slug}',           [QuizController::class,   'show'])       ->name('quiz.show');
    Route::post('/quizes/{topic:slug}/submit',   [QuizController::class,   'submit'])     ->name('quiz.submit');
    Route::get('/quizes/{topic:slug}/result', [QuizController::class, 'result'])->name('quiz.result');
});

require __DIR__.'/auth.php';
