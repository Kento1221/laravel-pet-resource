<x-layout>
    <div class="d-flex flex-column align-items-center border-1 shadow p-5 mb-5">
        <h3>Pet resource</h3>

        @if(!isset($pets))
            <div class="d-flex flex-column align-items-center my-5 gap-3">
                <i class="fa-solid fa-ban fa-2xl fa-fade"></i>
                <h6 class="badge bg-secondary rounded mt-3">No pets found</h6>
            </div>
            <button class="btn btn-success rounded">
                <i class="fa-solid fa-plus fa-bounce"></i>
                <span class="ms-1">Add new pet</span>
            </button>
        @else
            <div class="w-100 d-flex justify-content-between align-items-end my-3">
                <div>
                    <p>Show only status of:</p>
                    <div class="flex gap-3">
                        @foreach(\App\Domain\Enum\PetStatus::cases() as $status)
                            <a href="{{ route('pet.index', ['status' => $status->value]) }}"
                               class="btn btn-primary btn-sm rounded">
                                <span class="ms-1">{{ ucfirst($status->value) }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="flex">
                    <a href="{{ route('pet.create') }}"
                       class="btn btn-success btn-sm rounded">
                        <i class="fa-solid fa-plus"></i>
                        <span class="ms-1">Add new pet</span>
                    </a>
                </div>
            </div>
            <table class="container table table-sm table-bordered table-striped">
                <thead>
                <tr>
                    <th class="col-1">Id</th>
                    <th class="col-1">Category</th>
                    <th class="col-1">Name</th>
                    <th class="col-1">Tags</th>
                    <th class="col-1">Status</th>
                    <th class="col-2">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pets->getCollection() as $pet)
                    <tr>
                        <td>{{ $pet->id }}</td>
                        <td>{{ $pet->category?->name }}</td>
                        <td>{{ $pet->name }}</td>
                        <td>{{ $pet->tags ? implode(', ', array_column($pet->tags->getCollection()->toArray(), 'name')) : '' }}</td>
                        <td>{{ ucfirst($pet->status->value) }}</td>
                        <td>
                            <div class="d-flex justify-content-around">
                                <a href="{{ route('pet.show', ['pet' => $pet->id]) }}"
                                   class="btn btn-sm btn-primary"><i class="fa-solid fa-eye me-1"></i> Show</a>
                                <a href="{{ route('pet.edit', ['pet' => $pet->id]) }}"
                                   class="btn btn-sm btn-warning"><i class="fa-solid fa-pencil me-1"></i> Edit</a>
                                <button data-pet-id="{{ $pet->id }}"
                                        class="btn btn-sm btn-danger delete-pet-button d-flex align-items-center">
                                    <i class="fa-solid fa-circle-notch fa-spin"
                                       style="display: none"></i>
                                    <i class="fa-solid fa-trash me-1"
                                       style="display: block"></i>
                                    <span class="px-1">Delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <script>
        $(document).ready(function () {
            const alertSuccess = $('.alert.alert-success');
            const alertError = $('.alert.alert-danger');

            $('.delete-pet-button').click(function ($e) {
                const id = $(this).data('pet-id')

                if (confirm('Are you sure you want to delete the pet?')) {
                    $(this).find('i.fa-trash').hide();
                    $(this).find('i.fa-circle-notch').show();

                    $.ajax({
                        type: "DELETE",
                        url: '/pet/' + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {

                            if (!data.success) {
                                showAlertError('Sorry, the pet could not be removed.')
                            }

                            location.reload();
                        },
                        error: function (data) {
                            showAlertError('Sorry, the pet could not be removed.')

                            location.reload();
                        }
                    })
                }
            });

            function showAlertError(message) {
                alertSuccess.hide();
                alertError.text(message);
                alertError.show();
            }
        });
    </script>
</x-layout>
