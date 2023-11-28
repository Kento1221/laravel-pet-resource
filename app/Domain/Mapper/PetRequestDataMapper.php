<?php
declare(strict_types=1);

namespace App\Domain\Mapper;

use App\Domain\DTO\CategoryData;
use App\Domain\DTO\PetData;
use App\Domain\Enum\PetStatus;
use App\Http\Requests\PetDataRequest;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;

class PetRequestDataMapper
{
    public function __construct(
        protected CategoryRepository $categoryRepository,
        protected TagRepository      $tagRepository,
    ) {}

    public function map(PetDataRequest $request, int $id = null): PetData
    {
        $categoryData = $this->categoryRepository->getCategoryData((int)$request->validated('category'));
        $tagsCollection = $this->tagRepository->getTagDataByIds($request->validated('tags'));

        return new PetData(
            $id,
            $categoryData,
            $request->validated('name'),
            explode(',', $request->validated('photoUrls')),
            $tagsCollection,
            PetStatus::from($request->validated('status')),
        );
    }
}
