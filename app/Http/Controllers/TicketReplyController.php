<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\StoreTicketReplyRequest;
use App\Http\Resources\TicketReplyResource;
use App\Models\Ticket;
use App\Http\Requests\UpdateTicketReplyRequest;
use App\Models\TicketReply;
use App\Notifications\NewTicketReply;
use Illuminate\Support\Facades\Auth;

class TicketReplyController extends Controller
{
    public function store(StoreTicketReplyRequest $request, Ticket $ticket): TicketReplyResource
    {
        $this->authorize('create', [TicketReply::class, $ticket]);

        $reply = $ticket->replies()->create([
            'user_id' => Auth::id(),
            'message' => $request->validated('message'),
        ]);

        $reply->load(['user', 'ticket']);

        $recipient = $ticket->recipientFor(Auth::user());

        if ($recipient && $recipient->id !== Auth::id()) {
            $recipient->notify(new NewTicketReply($reply));
        }

        return new TicketReplyResource($reply);
    }

    public function update(UpdateTicketReplyRequest $request, Ticket $ticket, TicketReply $reply): TicketReplyResource
    {
        $this->authorize('update', $reply);

        $reply->update($request->validated());

        $reply->load('user');

        return new TicketReplyResource($reply);
    }
}
