<?php
declare(strict_types=1);

namespace App\Domain\DTO;

use App\Domain\Collection\TagDataCollection;
use App\Domain\Enum\PetStatus;

class PetData
{
    public function __construct(
        public ?int               $id,
        public ?CategoryData      $category,
        public string             $name,
        public array              $photoUrls,
        public ?TagDataCollection $tags,
        public PetStatus          $status,
    ) {}
}
