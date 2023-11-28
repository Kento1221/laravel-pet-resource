<div class="form-group row">
    <label for="status"
           class="col-3 col-form-label">Status:</label>
    <div class="col-9">
        <select name="status"
                id="status"
                class="form-select">
            @foreach(\App\Domain\Enum\PetStatus::cases() as $petStatus)
                <option value="{{ $petStatus->value }}" {{ $status === $petStatus ? 'selected' : ''}}>
                    {{ ucfirst($petStatus->value) }}
                </option>
            @endforeach
        </select>
    </div>
</div>
