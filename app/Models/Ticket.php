<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\TicketStatus;

class Ticket extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'status' => TicketStatus::class,
        ];
    }

    protected $fillable = [
        'title',
        'category_id',
        'status',
        'issued_by_id',
        'issued_to_id',
    ];

    public function notes(): HasMany
    {
        return $this->hasMany(TicketNote::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(TicketReply::class);
    }

    public function issuedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by_id');
    }

    public function issuedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_to_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
