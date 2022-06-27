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
        $comment = Comment::create([
            'user_id' => auth()->user()->id,
            'ticket_id' => $request->ticketId,
            'body' => request('body'),
        ]);

        return redirect()->back()->with('success', 'Comment posted.');
    }

}
