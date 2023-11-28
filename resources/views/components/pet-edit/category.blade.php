<div class="form-group row">
    <label for="tags"
           class="col-3 col-form-label">Category:</label>
    <div class="col-9">
        <select name="category"
                id="category"
                class="form-select">
            <option value=""></option>
        </select>
    </div>

    <script>
        $(document).ready(function () {

            $("select#category").select2({
                data: {!!
                        json_encode($categories->map(fn($tag) => [
                        'id' => $tag['id'],
                        'text' => $tag['name'],
                        'selected' => $tag['name'] === $petCategory?->name]))
                      !!}
            });
        });
    </script>
</div>
