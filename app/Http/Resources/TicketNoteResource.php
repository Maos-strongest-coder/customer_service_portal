<?php

namespace App\Http\Resources;

use App\Traits\FormatsDates;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketNoteResource extends JsonResource
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
            'user_id' => $this->user_id,
            'message' => $this->message,
            'created_at' => $this->formatDate($this->created_at),
            'updated_at' => $this->formatDate($this->updated_at),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
