@php
    $bookingConfig = [
        'year' => $calendarYear,
        'month' => $calendarMonth,
        'days' => $calendarDays,
        'daysInMonth' => $calendarDaysInMonth,
        'startOffset' => $calendarStartOffset,
        'monthLabel' => $calendarMonthLabel,
    ];
@endphp
<section id="booking" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-16">
    <div class="text-center mb-10">
        <div class="floral-divider">
            <span class="uppercase tracking-[0.25em] text-xs font-semibold text-rose-500">Booking Survei</span>
        </div>
        <h2 class="section-title">Pilih Tanggal &amp; Kirim Permintaan Survei</h2>
    </div>

    <div x-data="bookingWidget(@js($bookingConfig))" class="grid lg:grid-cols-3 gap-6 items-start">

        {{-- Kalender --}}
        <div id="kalender" class="card p-6 scroll-mt-24">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-serif text-lg text-blush-900">Kalender Booking</h3>
            </div>

            <div class="flex items-center justify-between mb-4">
                <button @click="changeMonth(-1)" class="w-8 h-8 rounded-full border border-blush-200 flex items-center justify-center text-blush-600 hover:bg-blush-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/></svg>
                </button>
                <span class="text-sm font-semibold text-blush-800" x-text="monthLabel"></span>
                <button @click="changeMonth(1)" class="w-8 h-8 rounded-full border border-blush-200 flex items-center justify-center text-blush-600 hover:bg-blush-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 18l6-6-6-6"/></svg>
                </button>
            </div>

            <div class="grid grid-cols-7 gap-1 text-center text-[11px] font-semibold text-blush-500 mb-2">
                <span>SEN</span><span>SEL</span><span>RAB</span><span>KAM</span><span>JUM</span><span>SAB</span><span>MIN</span>
            </div>

            <div class="grid grid-cols-7 gap-1 relative" :class="loadingCalendar ? 'opacity-40 pointer-events-none' : ''">
                <template x-for="n in startOffset" :key="'blank-'+n"><span></span></template>
                <template x-for="day in daysInMonth" :key="day">
                    <div class="flex items-center justify-center">
                        <button type="button" @click="selectDay(day, days[day]?.status)" :class="dayClasses(day)" x-text="day"></button>
                    </div>
                </template>
            </div>

            <div class="flex flex-wrap gap-4 mt-5 pt-4 border-t border-blush-100 text-[11px] text-blush-600">
                <span class="flex items-center gap-1.5"><i class="w-3 h-3 rounded-full bg-cream-200 border border-blush-200 inline-block"></i> Tersedia</span>
                <span class="flex items-center gap-1.5"><i class="w-3 h-3 rounded-full bg-rose-200 inline-block"></i> Terbooking</span>
                <span class="flex items-center gap-1.5"><i class="w-3 h-3 rounded-full bg-blush-200 inline-block"></i> Penuh</span>
            </div>
        </div>

        {{-- Form --}}
        <div id="booking-form-panel" class="card p-6 scroll-mt-24">
            <h3 class="font-serif text-lg text-blush-900 mb-4">Booking Survei</h3>

            <template x-if="successMessage">
                <div class="mb-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3" x-text="successMessage" x-cloak></div>
            </template>
            <template x-if="errors.general">
                <div class="mb-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3" x-text="errors.general" x-cloak></div>
            </template>

            <form @submit.prevent="submitForm" class="space-y-4">
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-medium text-blush-600">Nama Lengkap</label>
                        <input type="text" x-model="form.name" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm" placeholder="Nama Lengkap">
                        <p class="text-xs text-red-500 mt-1" x-text="errors.name" x-cloak></p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-blush-600">No. WhatsApp</label>
                        <input type="text" x-model="form.whatsapp" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm" placeholder="08xxxxxxxxxx">
                        <p class="text-xs text-red-500 mt-1" x-text="errors.whatsapp" x-cloak></p>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-medium text-blush-600">Tanggal Pernikahan</label>
                        <input type="date" x-model="form.wedding_date" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
                        <p class="text-xs text-red-500 mt-1" x-text="errors.wedding_date" x-cloak></p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-blush-600">Lokasi Acara</label>
                        <input type="text" x-model="form.event_location" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm" placeholder="Lokasi Acara">
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-medium text-blush-600">Layanan yang Diminati</label>
                        <select x-model="form.service_id" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
                            <option value="">Pilih Layanan</option>
                            @foreach($servicesForBooking as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-blush-600">Paket yang Diminati</label>
                        <select x-model="form.package_id" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
                            <option value="">Pilih Paket (opsional)</option>
                            @foreach($packagesForBooking as $package)
                                <option value="{{ $package->id }}">{{ $package->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="text-xs font-medium text-blush-600">Pesan / Keterangan</label>
                    <textarea x-model="form.message" rows="3" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm" placeholder="Pesan / Keterangan"></textarea>
                </div>

                <button type="submit" :disabled="submitting" class="btn-primary w-full disabled:opacity-60">
                    <span x-show="!submitting">Kirim Booking</span>
                    <span x-show="submitting" x-cloak>Mengirim...</span>
                </button>
            </form>
        </div>

        {{-- Lokasi --}}
        <div class="card p-6 scroll-mt-24">
            <h3 class="font-serif text-lg text-blush-900 mb-4">Lokasi Kami</h3>
            <div class="rounded-xl overflow-hidden aspect-[4/3] mb-4 border border-blush-100">
                <iframe
                    title="Lokasi Fariza Wedding Organizer"
                    class="w-full h-full"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    src="https://www.openstreetmap.org/export/embed.html?bbox=106.6700%2C-6.3200%2C106.6900%2C-6.3000&layer=mapnik&marker=-6.3100%2C106.6800">
                </iframe>
            </div>
            <ul class="space-y-3 text-sm text-blush-700">
                <li class="flex items-start gap-2">
                    <svg class="w-4 h-4 mt-0.5 text-rose-500 shrink-0" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-7-6.4-7-11.5A7 7 0 0 1 19 9.5C19 14.6 12 21 12 21Z"/><circle cx="12" cy="9.5" r="2.3"/></svg>
                    Jl. Raya Serpong No. 123, Kel. Lengkong Gudang, Kec. Serpong, Kota Tangerang Selatan, Banten 15321
                </li>
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-500 shrink-0" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5c0 9 7 16 16 16l2-4-5-2-2 2c-2-1-4-3-5-5l2-2-2-5-4 0"/></svg>
                    0812-3456-7890
                </li>
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-500 shrink-0" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="m3 7 9 6 9-6"/></svg>
                    farizawedding@gmail.com
                </li>
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-500 shrink-0" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 3"/></svg>
                    Senin - Minggu, 08.00 - 20.00 WIB
                </li>
            </ul>
        </div>
    </div>
</section>
