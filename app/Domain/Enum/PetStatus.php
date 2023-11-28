<?php
declare(strict_types=1);

namespace App\Domain\Enum;

enum PetStatus: string
{
    case available = 'available';
    case pending   = 'pending';
    case sold      = 'sold';
}
