<?php
declare(strict_types=1);

namespace App\Domain\Constant;

class PetResponseKeys
{
    const REQUIRED_KEYS = [
        'id',
        'category',
        'name',
        'photoUrls',
        'tags',
        'status',
    ];
}
