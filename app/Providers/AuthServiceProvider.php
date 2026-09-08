<?php
namespace App\Providers;

use App\Models\Ticket;
use App\Policies\TicketPolicy;
use App\Models\TicketNote;
use App\Models\TicketReply;
use App\Models\User;
use App\Policies\UserPolicy;
use App\Policies\TicketReplyPolicy;
use App\Policies\TicketNotePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        $this->registerPolicies();
    }
        
    protected $policies = [
        Ticket::class => TicketPolicy::class,
        TicketNote::class => TicketNotePolicy::class,
        TicketReply::class => TicketReplyPolicy::class,
        User::class => UserPolicy::class,
    ];

}