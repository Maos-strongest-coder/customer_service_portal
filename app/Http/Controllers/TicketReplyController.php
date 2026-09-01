<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketReplyRequest;
use App\Http\Resources\TicketReplyResource;
use App\Models\Ticket;
use Illuminate\Http\Request;

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
}
