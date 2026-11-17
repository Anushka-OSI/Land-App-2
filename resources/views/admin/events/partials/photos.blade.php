{{--
    Photos for ONE language tab of an event. Needs $lang, $item.
    Each language has its own photos; photos added here are not shown in the other languages.
--}}
@php
    $info = \App\Support\Languages::ALL[$lang];
    $images = $item->exists ? $item->imagesFor($lang) : collect();
    $removing = array_map('intval', (array) old('remove_images', []));
    $field = "images_{$lang}";
@endphp

<div class="form-group photo-uploader" data-photo-uploader data-lang="{{ $lang }}" data-label="{{ $info['label'] }}">
    <label for="{{ $field }}">Photos <span class="hint">({{ $info['label'] }} – optional, up to
            {{ \App\Models\Event::MAX_IMAGES }} photos, JPG / PNG / WEBP / GIF, max 10 MB each. These photos are shown only
            with the {{ $info['label'] }} version. The first photo is the cover.)</span></label>

    @if($images->isNotEmpty())
        <div class="image-grid" data-existing>
            @foreach($images as $image)
                <label class="image-tile {{ in_array($image->id, $removing, true) ? 'removing' : '' }}">
                    <img src="{{ $image->url }}" alt="{{ $info['label'] }} photo {{ $loop->iteration }}">
                    @if($loop->first)
                        <span class="image-tag">Cover</span>
                    @endif
                    <span class="image-remove">
                        <input type="checkbox" name="remove_images[]" value="{{ $image->id }}"
                            @checked(in_array($image->id, $removing, true))>
                        Remove
                    </span>
                </label>
            @endforeach
        </div>
    @endif

    <div class="upload-box @error($field) is-invalid @enderror @error($field . '.*') is-invalid @enderror" data-box>
        <input type="file" id="{{ $field }}" name="{{ $field }}[]" accept="image/jpeg,image/png,image/webp,image/gif" multiple>
        <div class="upload-box-text">
            <strong>Click to choose {{ $info['label'] }} photos</strong> or drag them here
            <span data-remaining></span>
        </div>
    </div>
    <div class="image-grid" data-new></div>
    <small class="form-error" data-error hidden></small>
    @error($field) <small class="form-error">{{ $message }}</small> @enderror
    @foreach($errors->get($field . '.*') as $messages)
        <small class="form-error">{{ $messages[0] }}</small>
        @break
    @endforeach
</div>
