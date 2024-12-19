<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{

    public function index(Category $category)
    {
        $threadsPin = Thread::where('category_id', $category->id) // почему pinned? если есть removED // ¯\_(ツ)_/¯
                            ->where('is_pin', true) 
                            ->latest()
                            ->get(); 
        $threads = Thread::where('category_id', $category->id)
                        ->where('is_pin', false)
                        ->latest()
                        ->paginate(10);
        $threads->each(function ($thread) {
            if ($thread->is_removed) {
                $thread->body = "[ Тред удален ]";
            }
        });
        return view('threads.index', compact('threads', 'category', 'threadsPin'));
    }

    public function show(Thread $thread)
    {
        $thread = Thread::with(['user', 'category', 'comments'])->findOrFail($thread->id);
        $commentsPin = [];
    
        $thread->comments->each(function ($comment) use (&$commentsPin) {
            if ($comment->is_removed) {
                $comment->body = "";
                $comment->image_path = null;
            }
            if ($comment->is_pin) {
                $commentsPin[] = $comment;
            }
        });
    
        return view('threads.show', compact('thread', 'commentsPin'));
    }
    

    public function create(Category $category)
    {
        $categoryCurrect = $category;
        $categories = Category::all();
        return view('threads.create', compact('categories', 'categoryCurrect'));
    }

    public function edit(Thread $thread)
    {
        $categories = Category::all();
        return view('threads.edit', compact('thread', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $uploadImage = $request->file('image')->store('images', 'public');
        } else {
            $uploadImage = null;
        }    

        $thread = Thread::create([
            'title' => $request->title,
            'body' => $request->body,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
            'image_path' => $uploadImage
        ]);

        return view('threads.show', compact('thread'));
    }

    public function update(Request $request, Thread $thread)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $uploadImage = $request->file('image')->store('images', 'public');
        } else {
            $uploadImage = $thread->image_path;
        }    

        $thread->update([
            'title' => $request->title,
            'body' => $request->body,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
            'image_path' => $uploadImage
        ]);

        return view('threads.show', compact('thread'));
    }

    // Чекни модель на счет этого
    public function remove(Thread $thread)
    {
        $thread->remove();
        return back();
    }
    // и этого
    public function restore(Thread $thread)
    {
        $thread->restore();
        return back();
    }

    public function pin(Thread $thread)
    {
        $thread->pin();
        return back();
        
    }
}
