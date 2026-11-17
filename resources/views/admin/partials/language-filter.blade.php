<select name="language" class="form-input" onchange="this.form.submit()" aria-label="Language">
    <option value="">Any language</option>
    @foreach(\App\Support\Languages::ALL as $code => $lang)
        <option value="{{ $code }}" @selected(request('language') === $code)>Has {{ \App\Support\Languages::label($code) }}</option>
    @endforeach
</select>
