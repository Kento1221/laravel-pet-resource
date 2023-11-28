<?php
declare(strict_types=1);

namespace App\Domain\Mapper;

use App\Domain\Collection\TagDataCollection;
use App\Domain\DTO\CategoryData;
use App\Domain\DTO\PetData;
use App\Domain\DTO\TagData;
use App\Domain\Enum\PetStatus;

class ResponsePetDataMapper
{
    public function map(array $petDataFromResponse): PetData
    {
        return new PetData(
            $petDataFromResponse['id'],
            array_key_exists('category', $petDataFromResponse)
                ? new CategoryData($petDataFromResponse['category']['id'], $petDataFromResponse['category']['name'])
                : null,
            $petDataFromResponse['name'] ?? '',
            $petDataFromResponse['photoUrls'],
            empty($petDataFromResponse['tags'])
                ? null
                : new TagDataCollection(collect(array_map(
                    fn($tag) => new TagData($tag['id'], $tag['name'] ?? ''),
                    $petDataFromResponse['tags']
                ))
            ),
            PetStatus::from($petDataFromResponse['status']),
        );
    }
}
