<?php

namespace App\Enums;

enum ReservationStatus
{
    case PENDING;
    case CONFIRMED;
    case CANCELLED;
    case COMPLETED;

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::CONFIRMED => 'Confirmed',
            self::CANCELLED => 'Cancelled',
            self::COMPLETED => 'Completed',
        };
    }
}
