<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">Manajemen Pengguna</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Lihat semua akun guru dan admin di sistem.</p>
            </div>
            <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-2xl shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">Tambah Pengguna</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900 dark:border-emerald-700 dark:bg-emerald-950 dark:text-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 rounded-3xl bg-rose-50 p-4 text-sm text-rose-700 dark:bg-rose-950 dark:text-rose-200">
                    <p class="font-semibold">Terjadi kesalahan:</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-950">
                <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                    <thead class="bg-slate-50 dark:bg-slate-900">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Role</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Dibuat</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-700 dark:bg-slate-950">
                        @forelse($users as $user)
                            <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-900">
                                <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-slate-100">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700 dark:bg-slate-800 dark:text-slate-100">{{ ucfirst($user->role) }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">{{ $user->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-right text-sm font-medium space-x-2">
                                    <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center rounded-full px-3 py-1 text-sky-600 hover:bg-sky-50 dark:text-sky-300 dark:hover:bg-slate-800">Edit</a>
                                    @if(auth()->id() !== $user->id)
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus akun ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center rounded-full px-3 py-1 text-rose-600 hover:bg-rose-50 dark:text-rose-400 dark:hover:bg-slate-800">Hapus</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-sm text-slate-500 dark:text-slate-400">Tidak ada pengguna terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
