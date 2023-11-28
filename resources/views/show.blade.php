<x-layout>
    <div class="container d-flex flex-column col-6 shadow-sm gap-3 py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h3>Pet details</h3>
            <a href="{{ route('pet.edit', ['pet' => $petData->id]) }}"
               class="btn btn-primary btn-rounded btn-sm">
                <i class="fa-solid fa-pencil me-1"></i>
                <span>Edit</span>
            </a>
        </div>
        <x-pet-detail :name="'id'"
                      :label="'ID'"
                      :disabled="true"
                      :value="$petData->id"
        />

        <x-pet-detail :name="'category'"
                      :label="'Category'"
                      :disabled="true"
                      :value="$petData->category?->name ?? ''"
        />

        <x-pet-detail :name="'name'"
                      :label="'Name'"
                      :disabled="true"
                      :value="$petData->name"
        />

        <x-pet-detail :name="'photoUrls'"
                      :label="'Photo URLs'"
                      :disabled="true"
                      :value="implode(', ' , $petData->photoUrls)"
        />

        <x-pet-detail :name="'tags'"
                      :label="'Tags'"
                      :disabled="true"
                      :value="implode(', ' , array_column($petData->tags?->toArray() ?? [], 'name'))"
        />

        <x-pet-detail :name="'status'"
                      :label="'Status'"
                      :disabled="true"
                      :value="ucfirst($petData->status->value)"
        />
    </div>
</x-layout>
