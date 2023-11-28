<x-layout>
    <div class="container d-flex flex-column col-6 shadow-sm gap-3 py-3">
        <h3>Create new pet</h3>
        <form class="flex flex-column"
              action="{{ route('pet.store') }}"
              method="POST">
            {{ csrf_field() }}
            <x-pet-create.text-input
                name="name"
                label="Name"
                disabled="0"
                value=""
            ></x-pet-create.text-input>
            <x-pet-create.select2
                label="Category"
                name="category"
                :data="$categories"
            ></x-pet-create.select2>
            <x-pet-create.text-input
                name="photoUrls"
                label="Photo urls"
                disabled="0"
                value=""
                placeholder="Comma separated links, eg. localhost,localhost,localhost"
            ></x-pet-create.text-input>
            <x-pet-create.select2
                label="Tags"
                name="tags"
                multiple="1"
                :data="$tags"
            ></x-pet-create.select2>
            <x-pet-create.select2
                label="Status"
                name="status"
                :data="$statuses"
            ></x-pet-create.select2>

            <div class="text-end">
                <button type="submit"
                        class="btn btn-primary">Create
                </button>
            </div>
        </form>
    </div>
</x-layout>
