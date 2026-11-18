/* ============================================================
   Event calendar (partials/event-calendar.blade.php)
   Month view with department events, public holidays, Poya days,
   special holidays and special working days.
   ============================================================ */

(() => {
    const root = document.querySelector('[data-calendar]');
    if (!root) return;

    const readJson = (selector, fallback) => {
        try { return JSON.parse(root.querySelector(selector)?.textContent || ''); } catch { return fallback; }
    };

    const strings = readJson('.cal-strings', { types: {} });
    const endpoint = root.dataset.endpoint;
    const today = root.dataset.today;

    const titleEl = root.querySelector('.cal-month-title');
    const weekdaysEl = root.querySelector('.cal-weekdays');
    const daysEl = root.querySelector('.cal-days');
    const detailEl = root.querySelector('.cal-detail');

    // Day colour: a special working day wins over a holiday; holidays win over events.
    const DAY_PRIORITY = ['working_day', 'special_holiday', 'holiday', 'poya', 'event'];
    const OFF_TYPES = ['holiday', 'poya', 'special_holiday'];

    const cache = new Map();             // 'YYYY-MM' -> entries
    let current = root.dataset.month;    // 'YYYY-MM'
    let selected = null;                 // 'YYYY-MM-DD'

    cache.set(current, readJson('.cal-initial', []));

    /* ── Helpers ───────────────────────────────────────────── */
    const pad = (n) => String(n).padStart(2, '0');
    const iso = (y, m, d) => `${y}-${pad(m)}-${pad(d)}`;
    const parseMonth = (ym) => ym.split('-').map(Number);
    const shiftMonth = (ym, delta) => {
        const [y, m] = parseMonth(ym);
        const date = new Date(y, m - 1 + delta, 1);
        return `${date.getFullYear()}-${pad(date.getMonth() + 1)}`;
    };
    const toDate = (isoDate) => {
        const [y, m, d] = isoDate.split('-').map(Number);
        return new Date(y, m - 1, d);
    };
    // Names come from the server (Sunday first) – browsers do not all know Sinhala / Tamil names
    const monthTitle = (y, m) => `${strings.months[m - 1]} ${y}`;
    const longDate = (date) => `${strings.weekdays[date.getDay()]}, ${date.getDate()} ${strings.months[date.getMonth()]} ${date.getFullYear()}`;
    const shortDate = (date, withYear = false) =>
        `${date.getDate()} ${strings.monthsShort[date.getMonth()]}${withYear ? ` ${date.getFullYear()}` : ''}`;
    const escapeHtml = (text) => String(text ?? '').replace(/[&<>"']/g, (c) => (
        { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]
    ));

    const entriesOn = (entries, day) => entries.filter((e) => e.start <= day && e.end >= day);

    /* ── Weekday names (Sunday first) ──────────────────────── */
    weekdaysEl.innerHTML = strings.weekdaysShort
        .map((name, i) => `<span class="${i === 0 || i === 6 ? 'is-weekend' : ''}">${escapeHtml(name)}</span>`)
        .join('');

    /* ── Rendering ─────────────────────────────────────────── */
    function render() {
        const [y, m] = parseMonth(current);
        const entries = cache.get(current) || [];
        const firstWeekday = new Date(y, m - 1, 1).getDay();
        const daysInMonth = new Date(y, m, 0).getDate();

        titleEl.textContent = monthTitle(y, m);

        let html = '';
        for (let i = 0; i < firstWeekday; i++) html += '<span class="cal-day is-blank" aria-hidden="true"></span>';

        for (let d = 1; d <= daysInMonth; d++) {
            const day = iso(y, m, d);
            const dayEntries = entriesOn(entries, day);
            const types = [...new Set(dayEntries.map((e) => e.type))];
            const main = DAY_PRIORITY.find((t) => types.includes(t));
            const weekday = (firstWeekday + d - 1) % 7;

            const classes = ['cal-day'];
            if (weekday === 0 || weekday === 6) classes.push('is-weekend');
            if (main) classes.push(`is-${main}`);
            if (main !== 'working_day' && types.some((t) => OFF_TYPES.includes(t))) classes.push('is-off');
            if (day === today) classes.push('is-today');
            if (day === selected) classes.push('is-selected');

            const label = [longDate(toDate(day)),
                ...dayEntries.map((e) => e.title)].join(' – ');

            const dots = types
                .sort((a, b) => DAY_PRIORITY.indexOf(a) - DAY_PRIORITY.indexOf(b))
                .map((t) => `<span class="cal-dot cal-dot--${t}"></span>`).join('');

            html += `<button type="button" class="${classes.join(' ')}" data-day="${day}"
                        aria-label="${escapeHtml(label)}" aria-pressed="${day === selected}"
                        ${day === today ? 'aria-current="date"' : ''}>
                        <span class="cal-day-num">${d}</span>
                        <span class="cal-day-dots" aria-hidden="true">${dots}</span>
                     </button>`;
        }

        daysEl.innerHTML = html;
        renderDetail();
    }

    function renderDetail() {
        if (!selected || !selected.startsWith(current)) {
            detailEl.innerHTML = `<p class="cal-detail-hint">${escapeHtml(strings.selectDay)}</p>`;
            return;
        }

        const dayEntries = entriesOn(cache.get(current) || [], selected);
        const heading = longDate(toDate(selected));

        const items = dayEntries.length
            ? dayEntries.map((e) => {
                const range = e.start !== e.end
                    ? `<span class="cal-detail-range">${escapeHtml(shortDate(toDate(e.start)))} – ${escapeHtml(shortDate(toDate(e.end), true))}</span>`
                    : '';
                return `<li class="cal-detail-item cal-detail-item--${e.type}">
                    <span class="cal-type cal-type--${e.type}">${escapeHtml(strings.types[e.type] || '')}</span>
                    <strong class="cal-detail-name">${escapeHtml(e.title)}</strong>
                    ${e.time ? `<span class="cal-detail-time">${escapeHtml(e.time)}</span>` : ''}
                    ${range}
                    ${e.description ? `<p class="cal-detail-desc">${escapeHtml(e.description)}</p>` : ''}
                </li>`;
            }).join('')
            : `<li class="cal-detail-none">${escapeHtml(strings.nothing)}</li>`;

        detailEl.innerHTML = `<h4 class="cal-detail-title">${escapeHtml(heading)}</h4><ul class="cal-detail-list">${items}</ul>`;
    }

    /* ── Loading other months ──────────────────────────────── */
    let request = 0;
    async function show(month) {
        current = month;
        const mine = ++request;

        if (!cache.has(month)) {
            root.classList.add('is-loading');
            titleEl.textContent = strings.loading || '…';
            try {
                const response = await fetch(`${endpoint}?month=${month}`, {
                    headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                });
                if (!response.ok) throw new Error(response.status);
                cache.set(month, (await response.json()).entries || []);
            } catch {
                if (mine === request) {
                    root.classList.remove('is-loading');
                    titleEl.textContent = monthTitle(...parseMonth(month));
                    daysEl.innerHTML = '';
                    detailEl.innerHTML = `<p class="cal-detail-hint">${escapeHtml(strings.error)}</p>`;
                }
                return;
            }
        }

        if (mine !== request) return; // the visitor already moved to another month
        root.classList.remove('is-loading');
        render();
    }

    /* ── Events ────────────────────────────────────────────── */
    root.querySelector('[data-cal-prev]')?.addEventListener('click', () => show(shiftMonth(current, -1)));
    root.querySelector('[data-cal-next]')?.addEventListener('click', () => show(shiftMonth(current, 1)));
    root.querySelector('[data-cal-today]')?.addEventListener('click', () => {
        selected = today;
        show(today.slice(0, 7));
    });

    daysEl.addEventListener('click', (event) => {
        const button = event.target.closest('[data-day]');
        if (!button) return;
        selected = button.dataset.day;
        render();
    });

    // Arrow keys move between days
    daysEl.addEventListener('keydown', (event) => {
        const steps = { ArrowLeft: -1, ArrowRight: 1, ArrowUp: -7, ArrowDown: 7 };
        if (!(event.key in steps) || !event.target.matches('[data-day]')) return;
        event.preventDefault();
        const next = toDate(event.target.dataset.day);
        next.setDate(next.getDate() + steps[event.key]);
        const day = iso(next.getFullYear(), next.getMonth() + 1, next.getDate());
        selected = day;
        const focus = () => daysEl.querySelector(`[data-day="${day}"]`)?.focus();
        if (day.slice(0, 7) !== current) show(day.slice(0, 7)).then(focus);
        else { render(); focus(); }
    });

    // Start with today selected when something is on today
    if (entriesOn(cache.get(current), today).length) selected = today;
    render();

    /* ── Opening / closing the full-screen view ────────────── */
    const modal = document.getElementById('event-calendar');
    const panel = modal?.querySelector('.cal-panel');
    const opener = document.querySelector('.cal-fab');
    let lastFocus = null;

    const focusables = () => [...modal.querySelectorAll('button, [href], [tabindex]:not([tabindex="-1"])')]
        .filter((el) => !el.disabled && el.offsetParent !== null);

    function open() {
        if (!modal || !modal.hidden) return;
        lastFocus = document.activeElement;
        document.querySelector('.cal-fab-wrap')?.classList.remove('show-teaser');
        modal.hidden = false;
        document.body.classList.add('cal-open');
        opener?.setAttribute('aria-expanded', 'true');
        panel.focus();
    }

    function close() {
        if (!modal || modal.hidden) return;
        modal.hidden = true;
        document.body.classList.remove('cal-open');
        opener?.setAttribute('aria-expanded', 'false');
        if (location.hash === '#event-calendar') history.replaceState(null, '', location.pathname + location.search);
        (lastFocus || opener)?.focus();
    }

    document.querySelectorAll('[data-cal-open]').forEach((el) => el.addEventListener('click', open));

    // Show the "Coming up" bubble for a few seconds, once per visit (not on every page)
    const wrap = document.querySelector('.cal-fab-wrap');
    if (wrap?.querySelector('[data-cal-teaser]') && !document.body.classList.contains('has-language-gate')) {
        let seen = false;
        try { seen = sessionStorage.getItem('cal-teaser-seen') === '1'; } catch { /* storage blocked */ }
        if (!seen) {
            setTimeout(() => {
                wrap.classList.add('show-teaser');
                try { sessionStorage.setItem('cal-teaser-seen', '1'); } catch { /* storage blocked */ }
                setTimeout(() => wrap.classList.remove('show-teaser'), 6000);
            }, 1500);
        }
    }
    modal?.querySelectorAll('[data-cal-close]').forEach((el) => el.addEventListener('click', close));

    document.addEventListener('keydown', (event) => {
        if (!modal || modal.hidden) return;
        if (event.key === 'Escape') { close(); return; }
        if (event.key !== 'Tab') return;
        // keep keyboard focus inside the calendar while it is open
        const items = focusables();
        if (!items.length) return;
        const first = items[0];
        const last = items[items.length - 1];
        if (event.shiftKey && (document.activeElement === first || document.activeElement === panel)) {
            event.preventDefault(); last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault(); first.focus();
        }
    });

    // Links to #event-calendar open it too
    const openFromHash = () => { if (location.hash === '#event-calendar') open(); };
    window.addEventListener('hashchange', openFromHash);
    openFromHash();
})();
