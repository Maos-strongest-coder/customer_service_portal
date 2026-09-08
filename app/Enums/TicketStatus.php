<?php

namespace App\Enums;

enum TicketStatus: string
{
    case OPEN = 'open';
    case IN_PROGRESS = 'in progress';
    case CLOSED = 'closed';
}
