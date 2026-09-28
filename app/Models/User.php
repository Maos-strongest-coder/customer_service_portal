<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Ticket;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;



class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
    ];

    protected function fullName(): Attribute
    {
        return Attribute::get(
            fn() => trim("$this->first_name $this->last_name")
        );
    }

    public function ticketsIssued(): HasMany
    {
        return $this->hasMany(Ticket::class, 'issued_by_id');
    }

    public function ticketsAssigned(): HasMany
    {
        return $this->hasMany(Ticket::class, 'issued_to_id');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(TicketNote::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(TicketReply::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }
}
