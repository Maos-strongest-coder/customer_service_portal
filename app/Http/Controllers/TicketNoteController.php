<?php

namespace App\Http\Controllers;


use App\Models\Ticket;

use App\Http\Resources\TicketNoteResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateTicketNoteRequest;
use App\Models\TicketNote;

class TicketNoteController extends Controller
{
    public function index(Ticket $ticket)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $notes = $ticket->notes()->with('user')->get();

        return TicketNoteResource::collection($notes);
    }

    public function store(Ticket $ticket)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $note = $ticket->notes()->create([
            'user_id' => Auth::id(),
            'message' => request('message'),
        ]);

        $note->load('user');

        return new TicketNoteResource($note);
    }

    public function update(UpdateTicketNoteRequest $request, Ticket $ticket, TicketNote $note): TicketNoteResource
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $note->update($request->validated());

        $note->load('user');

        return new TicketNoteResource($note);
    }
}
