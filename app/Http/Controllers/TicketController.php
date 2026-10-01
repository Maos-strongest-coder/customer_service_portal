<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Http\Resources\TicketResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;

class TicketController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            $tickets = Ticket::with(['issuedBy', 'issuedTo', 'category'])->get();
        } else {
            $tickets = Ticket::with(['issuedBy', 'issuedTo', 'category'])->where('issued_by_id',  Auth::id())->get();
        }

        return TicketResource::collection($tickets);
    }

    public function store(StoreTicketRequest $request)
    {
        $ticket = Ticket::create([
            ...$request->validated(),
            'issued_by_id' => Auth::id(),
        ]);

        $ticket->load(['issuedBy', 'issuedTo', 'category']);

        return new TicketResource($ticket);
    }

    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        $ticket->load(['issuedBy', 'issuedTo', 'replies.user', 'category']);

        return new TicketResource($ticket);
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket): TicketResource
    {
        $this->authorize('update', $ticket);

        $ticket->update($request->validated());

        $ticket->load(['issuedBy', 'issuedTo', 'category']);

        return new TicketResource($ticket);
    }

    public function destroy(Ticket $ticket)
    {
        $this->authorize('delete', $ticket);

        $ticket->delete();

        return response()->json(['message' => 'Ticket deleted successfully']);
    }
}
