<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Thread $thread, Request $request)
    {
        $request->validate([
            'body' => 'required'
        ]);
        if ($request->hasFile('image')) {
            $uploadImage = $request->file('image')->store('images', 'public');
        } else {
            $uploadImage = null;
        }    
        $comment = Answer::create([
            'body' => $request->body,
            'user_id' => Auth::id(),
            'thread_id' => $thread->id,
            'image_path' => $uploadImage
        ]);
        return redirect()->route('threads.show', $thread);
    }

    public function update(Answer $comment, Request $request)
    {
        $request->validate([
            'body' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $uploadImage = $request->file('image')->store('images', 'public');
        } else {
            $uploadImage = $comment->image_path;
        }  

        $comment->where('id', $comment->id)->update([
            'body' => $request->body,
            'image_path' => $uploadImage
        ]);

        return redirect()->route('threads.show', $comment->thread);
    }

    public function remove(Answer $comment)
    {
        $comment->remove();
        return redirect()->route('threads.show', $comment->thread);
    }

    public function pin(Answer $comment)
    {
        $comment->pin();
        return redirect()->route('threads.show', $comment->thread);
    }
}
