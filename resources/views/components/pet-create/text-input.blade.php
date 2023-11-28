<div class="form-group row mb-3">
    <label for="{{ $name }}"
           class="col-3 col-form-label">{{ $label }}:</label>
    <div class="col-9">
        <input id="{{ $name }}"
               name="{{ $name }}"
               placeholder="{{ $placeholder ?? '' }}"
               type="text"
               class="form-control"
               {{ $disabled ? 'disabled' : '' }}
               value="{{ $value }}">
    </div>
</div>
