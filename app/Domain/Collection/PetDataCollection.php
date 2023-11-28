<?php
declare(strict_types=1);

namespace App\Domain\Collection;

use App\Domain\DTO\PetData;

class PetDataCollection extends DataCollection
{
    public function getDataClass(): string
    {
        return PetData::class;
    }
}
