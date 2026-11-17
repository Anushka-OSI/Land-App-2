{{-- Publish checkbox. Needs $item.
     The homepage shows the latest 5 published items automatically. --}}
<div class="form-checks">
    <label class="form-check">
        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $item->is_published) ? 'checked' : '' }}>
        <span><strong>Publish</strong> – visible on the website (untick to keep it as a draft). The latest 5 published items appear on the homepage automatically.</span>
    </label>
</div>
