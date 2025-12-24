<div class="form-group">
    <label for="tags">Tags</label>
    <select name="tags[]" id="tags" class="form-control" multiple>
        @foreach($tags as $tag)
            <option value="{{ $tag->id }}" {{ (isset($product) && $product->tags->contains($tag->id)) ? 'selected' : '' }}>{{ $tag->name }}</option>
        @endforeach
    </select>
    <small class="form-text text-muted">Hold Ctrl (Windows) or Command (Mac) to select multiple tags.</small>
</div>
