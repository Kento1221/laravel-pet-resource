<?php
declare(strict_types=1);

namespace App\Repository;

use App\Domain\Collection\PetDataCollection;
use App\Domain\Constant\PetResponseKeys;
use App\Domain\DTO\PetData;
use App\Domain\Enum\PetStatus;
use App\Domain\Mapper\RequestPetDataBodyMapper;
use App\Domain\Mapper\ResponsePetDataMapper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PetRepository
{
    public function __construct(
        protected ResponsePetDataMapper    $responseMapper,
        protected RequestPetDataBodyMapper $requestBodyMapper,
    ) {}

    public function createPet(PetData $newData): bool
    {
        $response = Http::post(
            config('swagger.base_url') . config('swagger.endpoints.pet.post.new'),
            $this->requestBodyMapper->map($newData)
        );

        return $response->status() === Response::HTTP_OK;
    }

    public function updatePet(PetData $newData): bool
    {
        $response = Http::put(
            config('swagger.base_url') . config('swagger.endpoints.pet.put.update'),
            $this->requestBodyMapper->map($newData)
        );

        return $response->status() === Response::HTTP_OK;
    }

    public function deletePet(string $id): bool
    {
        $response = Http::delete(
            config('swagger.base_url') . sprintf(config('swagger.endpoints.pet.delete'), $id));

        return $response->status() === Response::HTTP_OK;
    }

    public function getPetData(int $id): PetData
    {
        $response = Http::get(
            config('swagger.base_url') . sprintf(config('swagger.endpoints.pet.get.findById'), $id));

        $response->status() !== Response::HTTP_OK && match ($response->status()) {
            Response::HTTP_NOT_FOUND => throw new NotFoundHttpException('Pet not found'),
            Response::HTTP_BAD_REQUEST => throw new BadRequestHttpException('Invalid ID supplied'),
        };

        return $this->responseMapper->map($response->json());
    }

    public function getRawPetDataForStatus(PetStatus $status): Collection
    {
        $response = Http::get(
            config('swagger.base_url') . config('swagger.endpoints.pet.get.findByStatus'), [
            'status' => $status->value
        ]);

        $response->status() !== Response::HTTP_OK && match ($response->status()) {
            Response::HTTP_NOT_FOUND => throw new NotFoundHttpException('Pet not found'),
            Response::HTTP_BAD_REQUEST => throw new BadRequestHttpException('Invalid ID supplied'),
        };

        return collect($response->json());
    }

    public function getPetDataForStatus(PetStatus $status): PetDataCollection
    {
        return new PetDataCollection(
            $this->getRawPetDataForStatus($status)
                ->filter(
                    fn(array $data) => count(
                            array_intersect_key(array_flip(PetResponseKeys::REQUIRED_KEYS), $data)
                        ) === count(PetResponseKeys::REQUIRED_KEYS))
                ->map(
                    fn(array $data) => $this->responseMapper->map($data)
                )
        );
    }
}
