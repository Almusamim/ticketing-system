<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function create()
    {
        return Inertia::render('Ticket/Edit');
    }

    public function store(Request $request)
    {
        $request->merge([
            'user_id' => auth()->user()->id
        ]);

        $attributes = $request->validate([
            'user_id' => ['required'],
            'ticket_id' => ['required'],
            'body' => ['required'],
        ]);

        $comment = Comment::create($attributes);

        return redirect()->back()->with('success', 'Comment posted.');
    }
}
