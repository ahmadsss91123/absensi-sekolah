<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Rekap Kehadiran Siswa</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Lihat ringkasan kehadiran per siswa secara cepat.</p>
            </div>
            <a href="{{ route('students.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-900 text-white rounded-2xl shadow-sm hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-500">Kembali ke Siswa</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-5 mb-6">
                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200 dark:bg-slate-950 dark:ring-slate-700">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-500 dark:text-slate-400">Total Hadir</p>
                    <p class="mt-4 text-3xl font-semibold text-emerald-600 dark:text-emerald-300">{{ $recaps->sum('total_hadir') }}</p>
                </div>
                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200 dark:bg-slate-950 dark:ring-slate-700">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-500 dark:text-slate-400">Total Izin</p>
                    <p class="mt-4 text-3xl font-semibold text-amber-600 dark:text-amber-300">{{ $recaps->sum('total_izin') }}</p>
                </div>
                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200 dark:bg-slate-950 dark:ring-slate-700">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-500 dark:text-slate-400">Total Sakit</p>
                    <p class="mt-4 text-3xl font-semibold text-sky-600 dark:text-sky-300">{{ $recaps->sum('total_sakit') }}</p>
                </div>
                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200 dark:bg-slate-950 dark:ring-slate-700">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-500 dark:text-slate-400">Total Alpa</p>
                    <p class="mt-4 text-3xl font-semibold text-rose-600 dark:text-rose-300">{{ $recaps->sum('total_alpa') }}</p>
                </div>
                <div class="rounded-3xl bg-slate-900 p-6 text-white shadow-sm ring-1 ring-slate-700">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-300">Total Kehadiran</p>
                    <p class="mt-4 text-3xl font-semibold">{{ $recaps->sum('total_kehadiran') }}</p>
                </div>
            </div>

            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-950">
                <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                    <thead class="bg-slate-50 dark:bg-slate-900">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Nama Siswa</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Kelas</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Hadir</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Izin</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Sakit</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Alpa</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-700 dark:bg-slate-950">
                        @forelse($recaps as $recap)
                            <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-900">
                                <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-slate-100">{{ $recap->nama }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">{{ $recap->kelas }}</td>
                                <td class="px-6 py-4 text-center text-sm font-semibold text-emerald-600 dark:text-emerald-300">{{ $recap->total_hadir }}</td>
                                <td class="px-6 py-4 text-center text-sm font-semibold text-amber-600 dark:text-amber-300">{{ $recap->total_izin }}</td>
                                <td class="px-6 py-4 text-center text-sm font-semibold text-sky-600 dark:text-sky-300">{{ $recap->total_sakit }}</td>
                                <td class="px-6 py-4 text-center text-sm font-semibold text-rose-600 dark:text-rose-300">{{ $recap->total_alpa }}</td>
                                <td class="px-6 py-4 text-center text-sm font-semibold text-slate-900 dark:text-slate-100">{{ $recap->total_kehadiran }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-sm text-slate-500 dark:text-slate-400">Belum ada data siswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
