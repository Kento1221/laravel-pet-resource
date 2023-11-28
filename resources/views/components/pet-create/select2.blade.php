<div class="form-group row mb-3">
    <label for="{{ $name }}"
           class="col-3 col-form-label">{{ $label }}:</label>
    <div class="col-9">
        <select name="{{ $name }}{{ isset($multiple) ? '[]' : '' }}"
                id="{{ $name }}"
                {{isset($multiple) ? 'multiple="multiple"' : ''}}
                class="form-select">
            <option></option>
        </select>
    </div>

    <script>
        $(document).ready(function () {

            $("select#{{ $name }}").select2({
                placeholder: "Select {{ $name }}",
                data: {!!
                        json_encode($data->map(fn($datum) => [
                            'id' => $datum['id'],
                            'text' => $datum['name'],
                            'selected' => $datum['selected'] ?? false,
                        ]))
                      !!}
            });
        });
    </script>
</div>
