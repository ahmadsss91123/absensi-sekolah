<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Tambah Absensi</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Catat kehadiran siswa untuk tanggal yang dipilih.</p>
            </div>
            <a href="{{ route('attendances.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-900 text-white rounded-2xl shadow-sm hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-500">Kembali ke Absensi</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-950 dark:ring-slate-700">
                <div class="p-6 space-y-6 text-slate-900 dark:text-slate-100">
                    @if($errors->any())
                        <div class="rounded-3xl bg-rose-50 p-4 text-sm text-rose-700 dark:bg-rose-950 dark:text-rose-200">
                            <p class="font-semibold">Periksa kembali input Anda:</p>
                            <ul class="mt-2 list-disc space-y-1 pl-5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="GET" action="{{ route('attendances.create') }}" class="flex items-end gap-4">
                        <div class="flex-1">
                            <label for="kelas" class="block text-sm font-medium text-slate-700 dark:text-slate-200">Filter Kelas</label>
                            <select id="kelas" name="kelas" onchange="this.form.submit()" class="mt-2 block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
                                <option value="">Semua Kelas</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class }}" {{ $selectedKelas == $class ? 'selected' : '' }}>{{ $class }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <form action="{{ route('attendances.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label for="student_id" class="block text-sm font-medium text-slate-700 dark:text-slate-200">Siswa</label>
                                <select id="student_id" name="student_id" class="mt-2 block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100" required>
                                    <option value="">Pilih siswa</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>{{ $student->nama }} ({{ $student->nis }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="tanggal" class="block text-sm font-medium text-slate-700 dark:text-slate-200">Tanggal</label>
                                <input id="tanggal" name="tanggal" type="date" value="{{ old('tanggal') }}" class="mt-2 block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100" required>
                            </div>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-slate-700 dark:text-slate-200">Status</label>
                            <select id="status" name="status" class="mt-2 block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100" required>
                                <option value="">Pilih status</option>
                                <option value="hadir" {{ old('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="izin" {{ old('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                                <option value="sakit" {{ old('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="alpa" {{ old('status') == 'alpa' ? 'selected' : '' }}>Alpa</option>
                            </select>
                        </div>

                        <div class="rounded-3xl bg-slate-50 p-4 text-sm text-slate-600 dark:bg-slate-900 dark:text-slate-300">
                            <p class="font-semibold">Catatan:</p>
                            <p class="mt-2">Absensi hanya dapat dicatat satu kali per siswa untuk tanggal yang sama.</p>
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row sm:justify-between">
                            <a href="{{ route('attendances.index') }}" class="inline-flex items-center justify-center rounded-2xl bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-100 dark:hover:bg-slate-700">Batal</a>
                            <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-sky-600 px-4 py-3 text-sm font-semibold text-white hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500">Simpan Absensi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
