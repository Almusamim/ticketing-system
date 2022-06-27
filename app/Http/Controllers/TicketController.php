<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        return( inertia('Tickets/Index', [
            'tickets' => Ticket::query()
                ->with('user')
                ->when($request->input('search'), function ($query, $search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhereHas('user', function($q) use ($search) { 
                            $q->where('name', 'like', "%{$search}%");
                        });
                })
                ->when($request->has('sortby', 'direction'), function ($query, $hasOrderby) {
                    // dd($field);
                    $query->orderBy(request('sortby'), request('direction'));
                })
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($ticket) => [
                    'id' => $ticket->id,
                    'author' => [
                        'id' => $ticket->user->id,
                        'name' => $ticket->user->name,
                        'email' => $ticket->user->email,
                        'avatar' => $ticket->user->avatar
                    ],
                    'title' => $ticket->title,
                    'status' => $ticket->status,
                    'priority' => $ticket->priority,
                    'body' => $ticket->body,
                    'is_owner' => auth()->user()->id == $ticket->user->id,
                    'actions' => [
                        // TODO:
                        // 'edit' => auth()->user()->can('edit', $ticket),
                        'edit' => auth()->user()->is_admin
                    ]
                ]),

            'filters' => $request->only(['search', 'sortby', 'direction']),
            'can' => [
                'createTicket' => auth()->user()->is_admin,
                'edit' => auth()->user()->is_admin,
            ]
        ]));
    }

    public function create()
    {
        return inertia('Tickets/Create');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
        
        $ticket = Ticket::create([
            'user_id' => auth()->user()->id,
            'body' => request('body'),
            'title' => request('title'),
        ]);

        self::uploadMedia($ticket, $request->file('media'));

        return redirect('/tickets')->with('success', 'Ticket created.');;
    }

    public function edit(Ticket $ticket)
    {   
        return( inertia('Tickets/Edit', [
            'ticket' => [
                'id' => $ticket->id,
                'title' => $ticket->title,
                'status' => $ticket->status,
                'priority' => $ticket->priority,
                'body' => $ticket->body,
                'media_files' => $ticket->media_files,
                'comments' => $ticket->comments,
            ],
        ]));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'title' => 'required|max:50',
            'body' => 'required',
            // 'media' => 'nullable|image',
        ]);

        $ticket->update($request->only('title', 'status', 'priority', 'body'));

        Self::uploadMedia($ticket, $request->file('media'));

        return redirect()->back()->with('success', 'Ticket updated.');
    }

    private function uploadMedia($ticket, $media)
    {
        if ($media) {
            foreach ($media as $key => $file)
            {
                $ticket->addMedia($file)->toMediaCollection('media');
            }
        }
    }
}
