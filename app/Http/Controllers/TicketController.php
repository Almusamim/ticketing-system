<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        //TODO Create new query scopes in the model to clean up all the mess =)
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
                        'edit' => auth()->user()->is_admin || auth()->user()->id == $ticket->user->id
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
        $ticket = auth()->user()->tickets()->create(
            $request->validate([
                'title' => 'required',
                'body' => 'required',
            ])
        );

        self::uploadMedia($ticket, $request->file('media'));

        return redirect()->route('tickets.edit', $ticket->id)->with('success', 'Ticket created.');
    }

    public function edit(Ticket $ticket)
    {   
        return(inertia('Tickets/Edit', [
            'ticket' => [
                'id' => $ticket->id,
                'title' => $ticket->title,
                'status' => $ticket->status,
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
            'nullable|file|image|mimes:csv,txt,xlx,xls,pdf'
        ]);

        $ticket->update($request->only('title', 'status', 'priority', 'body'));

        Self::uploadMedia($ticket, $request->file('media'));

        return redirect()->back()->with('success', 'Ticket updated.');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Ticket deleted.');
    }
    
    private function uploadMedia($ticket, $media)
    {
        if ($media) {
            foreach ($media as $file)
            {
                $ticket->addMedia($file)->toMediaCollection('media');
            }
        }
    }
}
