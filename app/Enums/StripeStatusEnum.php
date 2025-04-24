<?php

namespace App\Enums;

enum StripeStatusEnum: string
{
    case SUCCEEDED = 'succeeded';
    case FAILED    = 'failed';
    case CANCELLED = 'cancelled';


    public function label(): string
    {
        return match ($this) {
            self::SUCCEEDED => 'Succeeded',
            self::FAILED    => 'Failed',
            self::CANCELLED => 'Cancelled',
        };
    }
}
