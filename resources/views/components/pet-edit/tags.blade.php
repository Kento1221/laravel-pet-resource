<div class="form-group row">
    <label for="tags"
           class="col-3 col-form-label">Tags:</label>
    <div class="col-9">
        <select name="tags[]"
                id="tags"
                multiple="multiple"
                class="form-select">
        </select>
    </div>

    <script>
        $(document).ready(function () {

            $("select#tags").select2({
                data: {!!
                        json_encode($tags->map(fn($tag) => [
                        'id' => $tag['id'],
                        'text' => $tag['name'],
                        'selected' => in_array($tag->name, $petTags?->getCollection()->pluck('name')->toArray() ?? [])]))
                      !!}
            });
        });
    </script>
</div>
