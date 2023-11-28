<x-layout>
    <form action="{{ route('pet.update', ['pet' => $petData->id]) }}"
          method="POST">
        @csrf
        <div class="container d-flex flex-column col-6 shadow-sm gap-3 py-3">
            <h3>Edit pet details</h3>
            <x-pet-detail :name="'id'"
                          :label="'ID'"
                          :disabled="true"
                          :value="$petData->id"
            />

            <x-pet-edit.category :categories="$categories"
                                 :petCategory="$petData->category"
            />

            <x-pet-detail :name="'name'"
                          :label="'Name'"
                          :disabled="false"
                          :value="$petData->name"
            />

            <x-pet-detail :name="'photoUrls'"
                          :label="'Photo URLs'"
                          :disabled="false"
                          :value="implode(',' , $petData->photoUrls)"
            />

            <x-pet-edit.tags :petTags="$petData->tags"
                             :tags="$tags"/>

            <x-pet-edit.status :status="$petData->status"/>

            <button type="submit"
                    class="btn btn-primary btn-sm mt-3">Confirm
            </button>
        </div>
    </form>
</x-layout>
