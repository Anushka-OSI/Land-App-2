{{--
    Full-screen language chooser, shown on a visitor's first visit (until a language is chosen).
    Each button reloads the current page with ?lang=xx, which App\Http\Middleware\SetLocale remembers.
    Text is shown in all three languages because we don't know the visitor's language yet.
--}}
<div class="language-gate" role="dialog" aria-modal="true" aria-labelledby="language-gate-title">
    <div class="language-gate-card">
        <img src="{{ asset('images/landTitle.jpg') }}" alt="" class="language-gate-emblem">

        <h1 class="language-gate-title" id="language-gate-title">
            <span lang="si">ඉඩම් හිමිකම් නිරවුල් කිරීමේ දෙපාර්තමේන්තුව</span>
            <span lang="ta">காணி உரித்து நிர்ணயத் திணைக்களம்</span>
            <span lang="en">Department of Land Title Settlement</span>
        </h1>

        <p class="language-gate-prompt">
            <span lang="si">කරුණාකර ඔබේ භාෂාව තෝරන්න</span>
            <span lang="ta">தயவுசெய்து உங்கள் மொழியைத் தேர்ந்தெடுக்கவும்</span>
            <span lang="en">Please select your language</span>
        </p>

        <div class="language-gate-options">
            @foreach(\App\Support\Languages::DISPLAY_ORDER as $code)
                @php $info = \App\Support\Languages::ALL[$code]; @endphp
                <a href="{{ \App\Support\Languages::switchUrl($code) }}" class="language-gate-btn" lang="{{ $code }}" hreflang="{{ $code }}">
                    <span class="language-gate-native">{{ $info['native'] }}</span>
                    @if($info['native'] !== $info['label'])
                        <span class="language-gate-latin" lang="en">{{ $info['label'] }}</span>
                    @endif
                </a>
            @endforeach
        </div>

        <p class="language-gate-note">
            <span lang="si">භාෂාව ඕනෑම වේලාවක පිටුවේ ඉහළින් වෙනස් කළ හැක.</span>
            <span lang="ta">மொழியை எந்த நேரத்திலும் பக்கத்தின் மேலே மாற்றலாம்.</span>
            <span lang="en">You can change the language at any time from the top of the page.</span>
        </p>
    </div>
</div>
