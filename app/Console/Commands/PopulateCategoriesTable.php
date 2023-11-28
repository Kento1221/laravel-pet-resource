<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Domain\Collection\CategoryDataCollection;
use App\Domain\DTO\CategoryData;
use App\Domain\Enum\PetStatus;
use App\Repository\CategoryRepository;
use App\Repository\PetRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class PopulateCategoriesTable extends Command
{
    const SIGNATURE = 'app:populate-categories-table';
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
    protected $description = 'Uses external pet data to populate categories table.';

    /**
     * Execute the console command.
     */
    public function handle(
        PetRepository      $petRepository,
        CategoryRepository $categoryRepository,
        Collection         $categories
    ): void {

        foreach (PetStatus::cases() as $status) {
            $petData = $petRepository->getRawPetDataForStatus($status);

            $categories = $categories->merge(
                $petData->pluck('category')
                    ->filter(fn($category) => $category !== null && !empty($category['name']))
                    ->unique(
                        fn($category) => $category['name']
                    )
            );
        }

        $categoryRepository->upsertCategories(
            new CategoryDataCollection(
                $categories->unique(
                    fn($category) => $category['name']
                )->map(
                    fn($category) => new CategoryData((int)$category['id'], $category['name'])
                )
            )
        );
    }
}
