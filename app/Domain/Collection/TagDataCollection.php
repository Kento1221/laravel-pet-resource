<?php
declare(strict_types=1);

namespace App\Domain\Collection;

use App\Domain\DTO\TagData;

class TagDataCollection extends DataCollection
{
    public function getDataClass(): string
    {
        return TagData::class;
    }
}
