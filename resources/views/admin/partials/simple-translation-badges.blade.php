{{-- EN / SI / TA badges for an English field with optional _si / _ta versions. Needs $item, $field --}}
<span class="lang-badges cell-langs">
    @foreach(\App\Support\Languages::ALL as $code => $lang)
        @php $has = $code === 'en' ? filled($item->{$field}) : filled($item->{"{$field}_{$code}"}); @endphp
        <span class="lang-badge {{ $has ? 'on' : '' }}" lang="{{ $code }}"
            title="{{ $lang['label'] }}: {{ $has ? 'added' : 'missing – please add it' }}">{{ $lang['short'] }}</span>
    @endforeach
</span>
