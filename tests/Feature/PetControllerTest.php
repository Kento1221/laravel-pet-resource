<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Console\Commands\PopulateCategoriesTable;
use App\Console\Commands\PopulateTagsTable;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CommandsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_populates_tags_in_database(): void
    {
        $this->assertCount(0, Tag::all());

        Artisan::call(PopulateTagsTable::SIGNATURE);

        $this->assertGreaterThan(0, Tag::query()->count());
    }

    /** @test */
    public function it_populates_categories_in_database(): void
    {
        $this->assertCount(0, Category::all());

        Artisan::call(PopulateCategoriesTable::SIGNATURE);

        $this->assertGreaterThan(0, Category::query()->count());
    }
}
