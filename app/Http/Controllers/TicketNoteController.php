<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\StoreTicketNoteRequest;
use App\Models\Ticket;

use App\Http\Resources\TicketNoteResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateTicketNoteRequest;
use App\Models\TicketNote;

class TicketNoteController extends Controller
{
    public function index(Ticket $ticket)
    {
        $this->authorize('view', TicketNote::class);
        
        $notes = $ticket->notes()->with('user')->get();

        return TicketNoteResource::collection($notes);
    }

    public function store(StoreTicketNoteRequest $request, Ticket $ticket) 
    {
        if (Auth::user()->role !== UserRole::ADMIN) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $note = $ticket->notes()->create([
            ...$request->validated(),
            'user_id' => Auth::id(),
        ]);

        $note->load('user');

        return new TicketNoteResource($note);
    }

    public function update(UpdateTicketNoteRequest $request, Ticket $ticket, TicketNote $note)
    {
        $this->authorize('update', $note);

        $note->update($request->validated());

        $note->load('user');

        return new TicketNoteResource($note);
    }

    public function destroy(Ticket $ticket, TicketNote $note)
    {
        $this->authorize('update', $note);

        $note->delete();

        return response()->json(['message' => 'Note deleted successfully']);
    }
}
