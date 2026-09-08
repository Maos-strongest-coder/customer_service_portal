<?php

namespace App\Traits;

trait FormatsDates
{
    protected function formatDate($date): string
    {
        return $date?->format('Y-m-d H:i:s');
    }
}