<?php
declare(strict_types=1);

namespace App\Repository;

use App\Domain\Collection\TagDataCollection;
use App\Domain\DTO\TagData;
use App\Models\Tag;
use Illuminate\Support\Collection;

class TagRepository
{
    public function getAllTags(): Collection
    {
        return Tag::query()->select(['id', 'external_id', 'name'])->get();
    }

    public function upsertTags(TagDataCollection $dataCollection): void
    {
        $dataCollection->getCollection()
            ->map(fn(TagData $data) => [
                'external_id' => $data->id,
                'name'        => $data->name,
            ])
            ->chunk(50)
            ->each(
                fn(Collection $chunk) => Tag::query()->upsert($chunk->toArray(), ['external_id', 'name'])
            );
    }

    public function getTagDataByIds(array $ids): TagDataCollection
    {
        $tags = Tag::query()->whereIn('id', $ids)->get();

        return new TagDataCollection(
            $tags->map(
                fn(Tag $tag) => new TagData($tag->getKey(), $tag->name, $tag->external_id)
            )
        );
    }

}
