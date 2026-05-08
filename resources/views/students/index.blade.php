<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Data Siswa</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Kelola profil siswa dan lihat absensi per kelas.</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('students.recap') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-2xl shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">Rekap Kehadiran</a>
                <a href="{{ route('students.create') }}" class="inline-flex items-center px-4 py-2 bg-sky-600 text-white rounded-2xl shadow-sm hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500">Tambah Siswa</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900 dark:border-emerald-700 dark:bg-emerald-950 dark:text-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-[1.5fr_1fr] mb-6">
                <div class="rounded-3xl bg-white p-6 ring-1 ring-slate-200 shadow-sm dark:bg-slate-950 dark:ring-slate-700">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm uppercase tracking-[0.25em] text-slate-500 dark:text-slate-400">Total Siswa</p>
                            <p class="mt-3 text-4xl font-semibold text-slate-900 dark:text-white">{{ $students->count() }}</p>
                        </div>
                        <div class="rounded-2xl bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-700 dark:bg-slate-800 dark:text-slate-200">{{ $classes->count() }} kelas</div>
                    </div>

                    @if($selectedKelas)
                        <p class="mt-4 rounded-2xl bg-slate-50 p-4 text-sm text-slate-600 dark:bg-slate-900 dark:text-slate-300">Filter aktif: <span class="font-semibold text-slate-900 dark:text-white">{{ $selectedKelas }}</span></p>
                    @else
                        <p class="mt-4 rounded-2xl bg-slate-50 p-4 text-sm text-slate-600 dark:bg-slate-900 dark:text-slate-300">Menampilkan semua siswa.</p>
                    @endif
                </div>

                <form method="GET" action="{{ route('students.index') }}" class="rounded-3xl bg-slate-950 p-6 ring-1 ring-slate-700 shadow-sm">
                    <h3 class="text-lg font-semibold text-white">Filter Kelas</h3>
                    <p class="mt-2 text-sm text-slate-400">Pilih kelas untuk menampilkan siswa sesuai pilihan.</p>

                    <div class="mt-6 space-y-4">
                        <div>
                            <label for="kelas" class="block text-sm font-medium text-slate-300">Kelas</label>
                            <select id="kelas" name="kelas" class="mt-2 block w-full rounded-2xl border border-slate-700 bg-slate-900 px-4 py-3 text-white shadow-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500">
                                <option value="">Semua kelas</option>
                                @foreach($classes as $kelas)
                                    <option value="{{ $kelas }}" @selected($selectedKelas === $kelas)>{{ $kelas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-sky-600 px-4 py-3 text-sm font-semibold text-white hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500">Terapkan</button>
                            <a href="{{ route('students.index') }}" class="inline-flex items-center justify-center rounded-2xl bg-slate-800 px-4 py-3 text-sm font-semibold text-slate-100 hover:bg-slate-700">Reset</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-950">
                <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                    <thead class="bg-slate-50 dark:bg-slate-900">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">NIS</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Kelas</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-700 dark:bg-slate-950">
                        @forelse($students as $student)
                            <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-900">
                                <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-slate-100">{{ $student->nama }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">{{ $student->nis }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">{{ $student->kelas }}</td>
                                <td class="px-6 py-4 text-right text-sm font-medium space-x-2">
                                    <a href="{{ route('students.show', $student) }}" class="rounded-full px-3 py-1 text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">Lihat</a>
                                    <a href="{{ route('students.edit', $student) }}" class="rounded-full px-3 py-1 text-sky-600 hover:bg-sky-50 dark:text-sky-300 dark:hover:bg-slate-800">Edit</a>
                                    <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus siswa ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-full px-3 py-1 text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-slate-800">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-sm text-slate-500 dark:text-slate-400">Belum ada data siswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
