<?php
declare(strict_types=1);

namespace App\Domain\Collection;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

abstract class DataCollection implements Arrayable
{
    const EXCEPTION_CLASS_MESSAGE = 'Invalid collection of class `%s` provided. Collection of class `%s` expected.';
    const EXCEPTION_COUNT_MESSAGE = 'Empty collection of class `%s` provided.';

    protected Collection $collection;

    public function __construct(Collection $collection)
    {
        $this->validateCollection($collection);
        $this->collection = $collection;
    }

    protected function validateCollection(Collection $collection): void
    {
        $className = $this->getDataClass();

        if ($collection->isEmpty()) {
            throw new \InvalidArgumentException(
                sprintf(self::EXCEPTION_COUNT_MESSAGE, $className)
            );
        }

        foreach ($collection as $item) {
            if (!$item instanceof $className) {
                throw new \InvalidArgumentException(
                    sprintf(self::EXCEPTION_CLASS_MESSAGE, $item::class, $className)
                );
            }
        }
    }

    public function getCollection(): Collection
    {
        return $this->collection;
    }

    public abstract function getDataClass(): string;


    public function toArray(): array
    {
        return $this->collection->toArray();
    }
}
