<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return match (auth()->user()->role) {
        'admin' => redirect()->route('dashboard.admin'),
        'guru' => redirect()->route('dashboard.guru'),
        default => abort(403, 'Akses dashboard tidak tersedia untuk role ini.'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/admin', function () {
        return view('dashboard');
    })->middleware('admin')->name('dashboard.admin');

    Route::get('/dashboard/guru', function () {
        if (auth()->user()->role !== 'guru') {
            abort(403, 'Akses ditolak. Hanya guru yang dapat mengakses halaman ini.');
        }

        return view('dashboard');
    })->name('dashboard.guru');

    Route::resource('users', UserController::class)
        ->except(['show'])
        ->middleware('admin');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('students/recap', [StudentController::class, 'recap'])->name('students.recap');
    Route::resource('students', StudentController::class);
    Route::get('attendances/bulk', [AttendanceController::class, 'bulkCreate'])->name('attendances.bulk.create');
    Route::post('attendances/bulk', [AttendanceController::class, 'bulkStore'])->name('attendances.bulk.store');
    Route::resource('attendances', AttendanceController::class);

});

require __DIR__.'/auth.php';
