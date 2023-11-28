<?php
declare(strict_types=1);

namespace App\Domain\Mapper;

use App\Domain\DTO\PetData;
use App\Domain\DTO\TagData;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;

class RequestPetDataBodyMapper
{
    public function __construct(
        protected CategoryRepository $categoryRepository,
        protected TagRepository      $tagRepository,
    ) {}

    public function map(PetData $petData): array
    {
        $categoryData = $this->categoryRepository->getCategoryData($petData->category->id);
        $tagsCollection = $this->tagRepository->getTagDataByIds(
            $petData->tags->getCollection()->pluck('id')->toArray()
        );

        return [
            'id'        => $petData->id,
            'category'  => [
                'id'   => $categoryData->externalId,
                'name' => $categoryData->name,
            ],
            'name'      => $petData->name,
            'photoUrls' => $petData->photoUrls,
            'tags'      => $tagsCollection->getCollection()->map(fn(TagData $data) => [
                'id'   => $data->externalId,
                'name' => $data->name,
            ])->toArray(),
            'status'    => $petData->status->value
        ];
    }
}
