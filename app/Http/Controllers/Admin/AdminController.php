<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Topic;
use App\Models\Question;
use App\Models\QuizAttempt;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'users'    => User::count(),
            'topics'   => Topic::count(),
            'questions'=> Question::count(),
            'attempts' => QuizAttempt::count(),
        ];
        return view('admin.index', compact('stats'));
    }
}
