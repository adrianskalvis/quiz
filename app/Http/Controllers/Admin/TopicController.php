<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::withCount('questions')->orderBy('name')->get();
        return view('admin.topics.index', compact('topics'));
    }

    public function create()
    {
        return view('admin.topics.form', ['topic' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'icon'  => 'nullable|string|max:10',
            'image' => 'nullable|image|max:2048',
            'color' => 'nullable|string|max:20',
        ]);

        $data = [
            'name'  => $request->name,
            'slug'  => Str::slug($request->name),
            'icon'  => $request->icon,
            'color' => $request->color ?? '#185FA5',
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('topics', 'public');
        }

        Topic::create($data);
        return redirect()->route('admin.topics.index')->with('success', 'Topic created.');
    }

    public function edit(Topic $topic)
    {
        return view('admin.topics.form', compact('topic'));
    }

    public function update(Request $request, Topic $topic)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'icon'  => 'nullable|string|max:10',
            'image' => 'nullable|image|max:2048',
            'color' => 'nullable|string|max:20',
        ]);

        $data = [
            'name'  => $request->name,
            'slug'  => Str::slug($request->name),
            'icon'  => $request->icon,
            'color' => $request->color ?? $topic->color,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('topics', 'public');
        }

        $topic->update($data);
        return redirect()->route('admin.topics.index')->with('success', 'Topic updated.');
    }

    public function destroy(Topic $topic)
    {
        $topic->delete();
        return back()->with('success', 'Topic deleted.');
    }
}
