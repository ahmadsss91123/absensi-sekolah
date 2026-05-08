<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Absensi Massal</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Pilih kelas dan tanggal lalu isi status untuk semua siswa sekaligus.</p>
            </div>
            <a href="{{ route('attendances.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-900 text-white rounded-2xl shadow-sm hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-500">Kembali ke Absensi</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="mb-6 rounded-3xl bg-rose-50 p-4 text-sm text-rose-700 dark:bg-rose-950 dark:text-rose-200">
                    <p class="font-semibold">Periksa kembali input Anda:</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-950 dark:ring-slate-700">
                <div class="p-6 space-y-6 text-slate-900 dark:text-slate-100">
                    <form action="{{ route('attendances.bulk.create') }}" method="GET" class="grid gap-6 lg:grid-cols-[320px_1fr]">
                        <div>
                            <label for="tanggal" class="block text-sm font-medium text-slate-700 dark:text-slate-200">Tanggal</label>
                            <input id="tanggal" name="tanggal" type="date" value="{{ old('tanggal', $selectedTanggal) }}" class="mt-2 block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
                        </div>

                        <div class="grid gap-6 lg:grid-cols-[1fr_160px]">
                            <div>
                                <label for="kelas" class="block text-sm font-medium text-slate-700 dark:text-slate-200">Kelas</label>
                                <select id="kelas" name="kelas" class="mt-2 block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
                                    <option value="">Pilih kelas</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class }}" @selected($selectedKelas === $class)>{{ $class }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-sky-600 px-4 py-3 text-sm font-semibold text-white hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500">Tampilkan</button>
                        </div>
                    </form>

                    <div class="rounded-3xl bg-slate-50 p-4 text-sm text-slate-600 dark:bg-slate-900 dark:text-slate-300">
                        <p class="font-semibold">Petunjuk</p>
                        <p class="mt-2">Pilih tanggal dan kelas terlebih dahulu. Setelah daftar siswa muncul, Anda dapat mengatur status untuk semua siswa sekaligus dengan kontrol di bawah.</p>
                    </div>

                    @if($selectedKelas)
                        @if($students->isEmpty())
                            <div class="rounded-3xl bg-amber-50 p-6 text-sm text-amber-900 dark:bg-amber-950 dark:text-amber-200">
                                Tidak ada siswa untuk kelas <strong>{{ $selectedKelas }}</strong>. Silakan pilih kelas lain.
                            </div>
                        @else
                            <form action="{{ route('attendances.bulk.store') }}" method="POST" class="space-y-6">
                                @csrf
                                <input type="hidden" name="kelas" value="{{ $selectedKelas }}">
                                <input type="hidden" name="tanggal" value="{{ $selectedTanggal }}">

                                <div class="grid gap-4 lg:grid-cols-[1fr_220px] items-end">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">Absensi untuk kelas <span class="text-slate-900 dark:text-slate-100">{{ $selectedKelas }}</span></p>
                                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Tanggal: {{ $selectedTanggal ? \Carbon\Carbon::parse($selectedTanggal)->format('d M Y') : '-' }}</p>
                                    </div>
                                    <div>
                                        <label for="setAllStatus" class="block text-sm font-medium text-slate-700 dark:text-slate-200">Atur Semua Status</label>
                                        <select id="setAllStatus" class="mt-2 block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
                                            <option value="">Pilih status</option>
                                            <option value="hadir">Hadir</option>
                                            <option value="izin">Izin</option>
                                            <option value="sakit">Sakit</option>
                                            <option value="alpa">Alpa</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-950">
                                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                                        <thead class="bg-slate-50 dark:bg-slate-900">
                                            <tr>
                                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Nama</th>
                                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">NIS</th>
                                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-700 dark:bg-slate-950">
                                            @foreach($students as $student)
                                                <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-900">
                                                    <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-slate-100">{{ $student->nama }}</td>
                                                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">{{ $student->nis }}</td>
                                                    <td class="px-6 py-4">
                                                        <select name="statuses[{{ $student->id }}]" class="status-select mt-2 block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
                                                            <option value="hadir" {{ old('statuses.' . $student->id) == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                                            <option value="izin" {{ old('statuses.' . $student->id) == 'izin' ? 'selected' : '' }}>Izin</option>
                                                            <option value="sakit" {{ old('statuses.' . $student->id) == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                                            <option value="alpa" {{ old('statuses.' . $student->id) == 'alpa' ? 'selected' : '' }}>Alpa</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="rounded-3xl bg-slate-50 p-4 text-sm text-slate-600 dark:bg-slate-900 dark:text-slate-300">
                                    <p class="font-semibold">Catatan</p>
                                    <p class="mt-2">Jika absensi sudah ada untuk siswa dan tanggal yang sama, data akan diperbarui menggunakan <code>updateOrCreate</code>.</p>
                                </div>

                                <div class="flex flex-col gap-3 sm:flex-row sm:justify-between">
                                    <a href="{{ route('attendances.index') }}" class="inline-flex items-center justify-center rounded-2xl bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-100 dark:hover:bg-slate-700">Batal</a>
                                    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">Simpan Absensi Massal</button>
                                </div>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const setAll = document.getElementById('setAllStatus');
            if (!setAll) {
                return;
            }

            setAll.addEventListener('change', function () {
                const statusInputs = document.querySelectorAll('.status-select');
                statusInputs.forEach(function (select) {
                    if (setAll.value) {
                        select.value = setAll.value;
                    }
                });
            });
        });
    </script>
</x-app-layout>
