<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Domain\Collection\TagDataCollection;
use App\Domain\DTO\TagData;
use App\Domain\Enum\PetStatus;
use App\Repository\PetRepository;
use App\Repository\TagRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class PopulateTagsTable extends Command
{
    const SIGNATURE = 'app:populate-tags-table';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = self::SIGNATURE;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uses external pet data to populate tags table.';

    /**
     * Execute the console command.
     */
    public function handle(
        PetRepository $petRepository,
        TagRepository $tagRepository,
        Collection    $tags
    ): void {

        foreach (PetStatus::cases() as $status) {
            $petData = $petRepository->getRawPetDataForStatus($status);

            $tags = $tags->merge(
                $petData->pluck('tags')
                    ->flatten(1)
                    ->filter(fn($tag) => $tag !== null && !empty($tag['name']))
                    ->unique(
                        fn($tag) => $tag['name']
                    )
            );
        }

        $tagRepository->upsertTags(
            new TagDataCollection(
                $tags->unique(
                    fn($tag) => $tag['name']
                )->map(
                    fn($tag) => new TagData((int)$tag['id'], $tag['name'])
                )
            )
        );
    }
}
