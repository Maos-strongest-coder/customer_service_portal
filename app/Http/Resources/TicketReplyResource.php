<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\FormatsDates;

class TicketReplyResource extends JsonResource
{
    use FormatsDates;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ticket_id' => $this->ticket_id,
            'message' => $this->message,
            'created_at' => $this->formatDate($this->created_at),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
