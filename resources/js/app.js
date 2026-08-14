import Alpine from 'alpinejs';

window.Alpine = Alpine;

const csrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

Alpine.data('heroSlider', (count) => ({
    index: 0,
    count,
    timer: null,

    init() {
        this.play();

        // Pause the autoplay while the tab is hidden/backgrounded so the timer can't
        // silently advance the index past what the (unrendered) transitions can catch
        // up on — that desync is what leaves a slide stuck blank until a hard reload.
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                this.stop();
            } else {
                this.stop();
                this.play();
            }
        });

        // bfcache restores (browser back/forward) resume this component's JS state as-is
        // without re-running init() — resync explicitly so a stale timer/index can't linger.
        window.addEventListener('pageshow', (event) => {
            if (event.persisted) {
                this.index = 0;
                this.stop();
                this.play();
            }
        });
    },

    play() {
        this.timer = setInterval(() => this.next(), 6000);
    },

    stop() {
        clearInterval(this.timer);
    },

    next() {
        this.index = (this.index + 1) % this.count;
    },

    prev() {
        this.index = (this.index - 1 + this.count) % this.count;
    },

    goTo(i) {
        this.index = i;
        this.stop();
        this.play();
    },

    manualNext() {
        this.next();
        this.stop();
        this.play();
    },

    manualPrev() {
        this.prev();
        this.stop();
        this.play();
    },
}));

Alpine.data('bookingWidget', (config) => ({
    year: config.year,
    month: config.month,
    days: config.days,
    daysInMonth: config.daysInMonth,
    startOffset: config.startOffset,
    monthLabel: config.monthLabel,
    loadingCalendar: false,

    form: {
        name: '',
        whatsapp: '',
        wedding_date: '',
        event_location: '',
        service_id: '',
        package_id: '',
        message: '',
    },
    submitting: false,
    errors: {},
    successMessage: '',

    monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],

    init() {
        const params = new URLSearchParams(window.location.search);
        const packageId = params.get('package');
        if (packageId) {
            this.form.package_id = packageId;
        }
    },

    async changeMonth(delta) {
        let m = this.month + delta;
        let y = this.year;
        if (m < 1) { m = 12; y -= 1; }
        if (m > 12) { m = 1; y += 1; }

        this.loadingCalendar = true;
        try {
            const res = await fetch(`/api/booking-calendar?year=${y}&month=${m}`);
            const data = await res.json();
            this.days = data.days;
            this.year = y;
            this.month = m;
            this.daysInMonth = new Date(y, m, 0).getDate();
            this.startOffset = (new Date(y, m - 1, 1).getDay() + 6) % 7;
            this.monthLabel = `${this.monthNames[m - 1]} ${y}`;
        } finally {
            this.loadingCalendar = false;
        }
    },

    selectDay(day, status) {
        if (status === 'penuh' || status === 'lewat') return;
        const mm = String(this.month).padStart(2, '0');
        const dd = String(day).padStart(2, '0');
        this.form.wedding_date = `${this.year}-${mm}-${dd}`;
        document.getElementById('booking-form-panel')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
    },

    dayClasses(day) {
        const info = this.days[day];
        if (!info) return '';
        const base = 'w-9 h-9 md:w-10 md:h-10 flex items-center justify-center rounded-full text-sm transition cursor-pointer select-none';

        if (info.status === 'lewat') return `${base} text-blush-300 cursor-not-allowed`;
        if (info.status === 'penuh') return `${base} bg-blush-500 text-white cursor-not-allowed line-through opacity-90`;
        if (info.status === 'terbooking') return `${base} bg-rose-400 text-white font-semibold hover:bg-rose-500`;
        if (this.form.wedding_date === `${this.year}-${String(this.month).padStart(2,'0')}-${String(day).padStart(2,'0')}`) {
            return `${base} bg-rose-500 text-white font-semibold ring-2 ring-rose-300 ring-offset-2`;
        }
        return `${base} bg-cream-100 text-blush-800 border border-blush-200 hover:bg-rose-100 hover:border-rose-300`;
    },

    async submitForm() {
        this.submitting = true;
        this.errors = {};
        this.successMessage = '';

        try {
            const res = await fetch('/booking-survei', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken(),
                },
                body: JSON.stringify(this.form),
            });

            const data = await res.json();

            if (res.status === 422) {
                Object.keys(data.errors || {}).forEach((key) => {
                    this.errors[key] = data.errors[key][0];
                });
                return;
            }

            if (!res.ok) {
                this.errors.general = 'Terjadi kesalahan. Silakan coba lagi.';
                return;
            }

            this.successMessage = data.message;
            this.form = { name: '', whatsapp: '', wedding_date: '', event_location: '', service_id: '', package_id: '', message: '' };
            await this.changeMonth(0);
        } catch (e) {
            this.errors.general = 'Tidak dapat terhubung ke server. Periksa koneksi Anda.';
        } finally {
            this.submitting = false;
        }
    },
}));

Alpine.start();

const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            revealObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.15, rootMargin: '0px 0px -60px 0px' });

document.querySelectorAll('.reveal').forEach((el) => revealObserver.observe(el));

// Top-nav "active" highlight for in-page anchor links (Beranda/Tentang Kami/MUA &
// Makeup/Kalender/Kontak all point at sections within the home page, so route-based
// matching alone leaves them permanently un-highlighted — this tracks scroll position
// instead. Paket Wedding/Galeri are separate pages and keep their route-based match.
const navSpyTargets = ['beranda', 'tentang', 'layanan', 'kalender', 'kontak']
    .map((id) => document.getElementById(id))
    .filter(Boolean);

if (navSpyTargets.length) {
    const navSpyLinks = document.querySelectorAll('[data-nav]');

    const setActiveNav = (id) => {
        navSpyLinks.forEach((link) => {
            const isMatch = link.dataset.nav === id;
            link.classList.toggle('text-rose-500', isMatch);
            link.classList.toggle('is-active', isMatch);
        });
    };

    const navSpyObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                setActiveNav(entry.target.id);
            }
        });
    }, { rootMargin: '-96px 0px -70% 0px', threshold: 0 });

    navSpyTargets.forEach((el) => navSpyObserver.observe(el));

    // The last section (Kontak, inside the short footer) can sit below the activation
    // band with no scroll room left to bring it up into it — the page simply ends first.
    // Force it active once the user has scrolled as far as the page allows.
    const lastNavTarget = navSpyTargets[navSpyTargets.length - 1];
    let navSpyTicking = false;
    document.addEventListener('scroll', () => {
        if (navSpyTicking) return;
        navSpyTicking = true;
        requestAnimationFrame(() => {
            navSpyTicking = false;
            const atBottom = window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 2;
            if (atBottom) {
                setActiveNav(lastNavTarget.id);
            }
        });
    }, { passive: true });
}
