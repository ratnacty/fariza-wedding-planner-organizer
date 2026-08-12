import Alpine from 'alpinejs';

window.Alpine = Alpine;

const csrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

Alpine.data('heroSlider', (count) => ({
    index: 0,
    count,
    timer: null,

    init() {
        this.play();
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
        if (info.status === 'penuh') return `${base} bg-blush-200/70 text-blush-500 cursor-not-allowed line-through`;
        if (info.status === 'terbooking') return `${base} bg-rose-200 text-rose-800 hover:bg-rose-300 font-medium`;
        if (this.form.wedding_date === `${this.year}-${String(this.month).padStart(2,'0')}-${String(day).padStart(2,'0')}`) {
            return `${base} bg-rose-500 text-white font-semibold ring-2 ring-rose-300 ring-offset-2`;
        }
        return `${base} bg-cream-200 text-blush-800 hover:bg-rose-100`;
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
