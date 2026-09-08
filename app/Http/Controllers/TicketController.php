<?php

namespace App\Http\Controllers;


use App\Enums\UserRole;
use App\Models\Ticket;
use App\Http\Resources\TicketResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTicketRequest;




class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userRole = Auth::user()->role;
        $userId = Auth::user()->id;

        if ($userRole === UserRole::ADMIN) {
            $tickets = Ticket::with(['issuedBy', 'issuedTo'])->get();
        } else {
            $tickets = Ticket::with(['issuedBy', 'issuedTo'])->where('issued_by_id',  $userId)->get();
        }

        return TicketResource::collection($tickets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        $ticket = Ticket::create([
            ...$request->validated(),
            'issued_by_id' => Auth::id(),
        ]);

        return new TicketResource($ticket);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        $ticket->load(['issuedBy', 'issuedTo', 'replies.user']);
        
        return new TicketResource($ticket);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTicketRequest $request, string $id)
    {
        $ticket = Ticket::findOrFail($id);

        $userRole = Auth::user()->role;
        $userId = Auth::user()->id;

        if ($userRole !== UserRole::ADMIN && $ticket->issued_by_id !== $userId) {
            return response()->json([
                'message' => 'You cannot update this ticket'
            ], 403);
        }
        

        $ticket->update($request->validated());

        return new TicketResource($ticket);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
