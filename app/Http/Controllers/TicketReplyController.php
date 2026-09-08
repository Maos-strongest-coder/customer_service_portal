<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\StoreTicketReplyRequest;
use App\Http\Resources\TicketReplyResource;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateTicketReplyRequest;
use App\Models\TicketReply;

class TicketReplyController extends Controller
{
    public function store(StoreTicketReplyRequest $request, Ticket $ticket): TicketReplyResource
    {
        $reply = $ticket->replies()->create([
            'user_id' => $request->user()->id,
            'message' => $request->validated('message'),
        ]);

        $reply->load('user');

        return new TicketReplyResource($reply);
    }

    public function update(UpdateTicketReplyRequest $request, Ticket $ticket, TicketReply $reply): TicketReplyResource
    {
        $userRole = Auth::user()->role;
        $userId = Auth::user()->id;

        if ($userRole !== UserRole::ADMIN && $reply->user_id !== $userId) {
            abort(403, 'You are not allowed to edit this reply.');
        }

        $reply->update($request->validated());

        $reply->load('user');

        return new TicketReplyResource($reply);
    }
}
