<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizesController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TopicController;
use App\Http\Controllers\Admin\QuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Breeze post-login redirect → /quizes
Route::redirect('/dashboard', '/quizes')->middleware('auth')->name('dashboard');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])   ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth user routes
Route::middleware(['auth'])->group(function () {
    Route::get('/quizes',                      [QuizesController::class, 'index'])      ->name('quizes');
    Route::get('/quizes/leaderboard',          [QuizesController::class, 'leaderboard'])->name('leaderboard');
    Route::get('/quizes/scores',               [QuizesController::class, 'scores'])     ->name('scores');
    Route::get('/quizes/{topic:slug}',         [QuizController::class,   'show'])       ->name('quiz.show');
    Route::post('/quizes/{topic:slug}/submit', [QuizController::class,   'submit'])     ->name('quiz.submit');
    Route::get('/quizes/{topic:slug}/result',  [QuizController::class,   'result'])     ->name('quiz.result');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Users
    Route::get('/users',                   [UserController::class,    'index'])     ->name('users.index');
    Route::patch('/users/{user}/role',     [UserController::class,    'updateRole'])->name('users.role');
    Route::delete('/users/{user}',         [UserController::class,    'destroy'])   ->name('users.destroy');

    // Topics
    Route::get('/topics',                  [TopicController::class,   'index'])     ->name('topics.index');
    Route::get('/topics/create',           [TopicController::class,   'create'])    ->name('topics.create');
    Route::post('/topics',                 [TopicController::class,   'store'])     ->name('topics.store');
    Route::get('/topics/{topic}/edit',     [TopicController::class,   'edit'])      ->name('topics.edit');
    Route::patch('/topics/{topic}',        [TopicController::class,   'update'])    ->name('topics.update');
    Route::delete('/topics/{topic}',       [TopicController::class,   'destroy'])   ->name('topics.destroy');

    // Questions
    Route::get('/topics/{topic}/questions',                        [QuestionController::class, 'index'])  ->name('questions.index');
    Route::get('/topics/{topic}/questions/create',                 [QuestionController::class, 'create']) ->name('questions.create');
    Route::post('/topics/{topic}/questions',                       [QuestionController::class, 'store'])  ->name('questions.store');
    Route::get('/topics/{topic}/questions/{question}/edit',        [QuestionController::class, 'edit'])   ->name('questions.edit');
    Route::patch('/topics/{topic}/questions/{question}',           [QuestionController::class, 'update']) ->name('questions.update');
    Route::delete('/topics/{topic}/questions/{question}',          [QuestionController::class, 'destroy'])->name('questions.destroy');
});

require __DIR__.'/auth.php';
