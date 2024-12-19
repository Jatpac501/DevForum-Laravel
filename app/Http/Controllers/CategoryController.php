<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Answer;
use App\Models\Thread;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $recentTopics = Thread::with('user')->latest()->take(5)->get();
        return view('homepage', compact('categories', 'recentTopics'));
    }
}
