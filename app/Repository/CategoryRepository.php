<?php
declare(strict_types=1);

namespace App\Repository;

use App\Domain\Collection\CategoryDataCollection;
use App\Domain\DTO\CategoryData;
use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryRepository
{
    public function getAllCategories(): Collection
    {
        return Category::query()->select(['id', 'external_id', 'name'])->get();
    }

    public function upsertCategories(CategoryDataCollection $dataCollection): void
    {
        $dataCollection->getCollection()
            ->map(fn(CategoryData $data) => [
                'external_id' => $data->id,
                'name'        => $data->name,
            ])
            ->chunk(50)
            ->each(
                fn(Collection $chunk) => Category::query()->upsert($chunk->toArray(), ['external_id', 'name'])
            );
    }

    public function getCategoryData(int $id): CategoryData
    {
        $category = Category::query()->find($id);
        return new CategoryData(
            $category->getKey(),
            $category->name,
            $category->external_id,
        );
    }

}
