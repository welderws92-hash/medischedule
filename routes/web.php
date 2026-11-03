<?php

use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Página inicial
Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    return match ($role) {
        'admin' => redirect()->route('admin.dashboard'),
        'doctor' => redirect()->route('doctor.dashboard'),
        'patient' => redirect()->route('patient.dashboard'),
        default => abort(403),
    };
})->middleware(['auth', 'verified'])->name('dashboard');
// Painel administrativo
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('dashboard.admin');
    })->name('admin.dashboard');
    Route::get('/admin/doctors', [DoctorController::class, 'index'])
        ->name('admin.doctors.index');
    Route::get('/admin/doctors/create', [DoctorController::class, 'create'])
        ->name('admin.doctors.create');
    Route::post('/admin/doctors', [DoctorController::class, 'store'])
        ->name('admin.doctors.store');
});

// Painel do médico
Route::middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/doctor/dashboard', function () {
        return view('dashboard.doctor');
    })->name('doctor.dashboard');
});

// Painel do paciente
Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/patient/dashboard', function () {
        return view('dashboard.patient');
    })->name('patient.dashboard');
});

// Perfil do usuário
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';
