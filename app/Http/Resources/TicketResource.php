<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\FormatsDates;

class TicketResource extends JsonResource
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
            'title' => $this->title,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'status' => $this->status,
            'issued_by' => new UserResource($this->whenLoaded('issuedBy')),
            'issued_to' => new UserResource($this->whenLoaded('issuedTo')),
            'created_at' => $this->formatDate($this->created_at),
            'updated_at' => $this->formatDate($this->updated_at),
            'replies' => TicketReplyResource::collection($this->whenLoaded('replies')),
        ];
    }
}
