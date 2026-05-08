<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Detail Absensi</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Informasi lengkap catatan kehadiran siswa.</p>
            </div>
            <a href="{{ route('attendances.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-900 text-white rounded-2xl shadow-sm hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-500">Kembali ke Absensi</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-950 dark:ring-slate-700">
                <div class="p-6 text-slate-900 dark:text-slate-100">
                    <div class="grid gap-6 sm:grid-cols-2">
                        <div class="rounded-3xl bg-slate-50 p-6 dark:bg-slate-900">
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Tanggal</p>
                            <p class="mt-3 text-lg font-semibold text-slate-900 dark:text-slate-100">{{ $attendance->tanggal->format('d M Y') }}</p>
                        </div>
                        <div class="rounded-3xl bg-slate-50 p-6 dark:bg-slate-900">
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Siswa</p>
                            <p class="mt-3 text-lg font-semibold text-slate-900 dark:text-slate-100">{{ $attendance->student->nama }} ({{ $attendance->student->nis }})</p>
                        </div>
                        <div class="rounded-3xl bg-slate-50 p-6 dark:bg-slate-900 sm:col-span-2">
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Status</p>
                            <span class="mt-3 inline-flex rounded-full bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-800 dark:bg-emerald-900/70 dark:text-emerald-200">{{ ucfirst($attendance->status) }}</span>
                        </div>
                    </div>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('attendances.edit', $attendance) }}" class="inline-flex items-center px-4 py-3 bg-sky-600 text-white rounded-2xl shadow-sm hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500">Edit Absensi</a>
                        <a href="{{ route('attendances.index') }}" class="inline-flex items-center px-4 py-3 bg-slate-100 text-slate-900 rounded-2xl hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-100 dark:hover:bg-slate-700">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
