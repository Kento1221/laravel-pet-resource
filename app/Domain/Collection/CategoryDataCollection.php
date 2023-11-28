<?php
declare(strict_types=1);

namespace App\Domain\Collection;

use App\Domain\DTO\CategoryData;

class CategoryDataCollection extends DataCollection
{
    public function getDataClass(): string
    {
        return CategoryData::class;
    }
}
