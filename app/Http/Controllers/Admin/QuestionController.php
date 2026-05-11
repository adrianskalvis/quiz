<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Topic $topic)
    {
        $questions = $topic->questions()->with('answers')->get();
        return view('admin.questions.index', compact('topic', 'questions'));
    }

    public function create(Topic $topic)
    {
        return view('admin.questions.form', ['topic' => $topic, 'question' => null]);
    }

    public function store(Request $request, Topic $topic)
    {
        $request->validate([
            'question_text'  => 'required|string',
            'answers'        => 'required|array|min:2',
            'answers.*'      => 'required|string',
            'correct_answer' => 'required|integer',
        ]);

        $question = Question::create([
            'topic_id'      => $topic->id,
            'question_text' => $request->question_text,
        ]);

        foreach ($request->answers as $i => $text) {
            Answer::create([
                'question_id' => $question->id,
                'answer_text' => $text,
                'is_correct'  => (int)$request->correct_answer === $i,
            ]);
        }

        return redirect()->route('admin.questions.index', $topic)
            ->with('success', 'Question added.');
    }

    public function edit(Topic $topic, Question $question)
    {
        $question->load('answers');
        return view('admin.questions.form', compact('topic', 'question'));
    }

    public function update(Request $request, Topic $topic, Question $question)
    {
        $request->validate([
            'question_text'  => 'required|string',
            'answers'        => 'required|array|min:2',
            'answers.*'      => 'required|string',
            'correct_answer' => 'required|integer',
        ]);

        $question->update(['question_text' => $request->question_text]);
        $question->answers()->delete();

        foreach ($request->answers as $i => $text) {
            Answer::create([
                'question_id' => $question->id,
                'answer_text' => $text,
                'is_correct'  => (int)$request->correct_answer === $i,
            ]);
        }

        return redirect()->route('admin.questions.index', $topic)
            ->with('success', 'Question updated.');
    }

    public function destroy(Topic $topic, Question $question)
    {
        $question->answers()->delete();
        $question->delete();
        return back()->with('success', 'Question deleted.');
    }
}
