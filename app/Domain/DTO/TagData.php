<?php
declare(strict_types=1);

namespace App\Domain\DTO;

class TagData
{
    public function __construct(
        public int     $id,
        public string  $name,
        public ?string $externalId = null,
    ) {}
}
