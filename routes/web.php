<?php

use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\Staff\AuthController as StaffAuthController;
use App\Http\Controllers\Staff\CheckInController;
use App\Http\Controllers\Staff\DashboardController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Business Forum KEK Registration Microsite Routes.
|
*/

// Landing Page
Route::get('/', function () {
    return view('landing');
})->name('home');

// Participant Registration
Route::get('/registrasi', [RegistrationController::class, 'create'])->name('registration.create');
Route::get('/registrasi/index', fn () => redirect()->route('registration.create'))->name('registration.index');

Route::post('/registrasi', [RegistrationController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('registration.store');

Route::get('/registrasi/sukses/{code}', [RegistrationController::class, 'success'])
    ->name('registration.success');

Route::post('/registrasi/kirim-ulang-email', [RegistrationController::class, 'resendEmail'])
    ->middleware('throttle:5,1')
    ->name('registration.resend-email');

// Digital Ticket (Protected Signed Route)
Route::get('/tiket/{ticketNumber}', [TicketController::class, 'show'])
    ->name('tickets.show');

// Staff Authentication
Route::get('/login', fn () => redirect()->route('staff.login'))->name('login');
Route::get('/staff/login', [StaffAuthController::class, 'create'])->name('staff.login');
Route::post('/staff/login', [StaffAuthController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('staff.login.store');
Route::post('/staff/logout', [StaffAuthController::class, 'destroy'])
    ->middleware('auth')
    ->name('staff.logout');

// Staff Operations (Scanner, Attendance Dashboard & Reports)
Route::middleware(['auth', 'staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/scanner', [CheckInController::class, 'index'])->name('scanner');
    Route::post('/check-in', [CheckInController::class, 'store'])->name('check-in.store');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/reports/attendance/csv', [DashboardController::class, 'exportCsv'])->name('reports.attendance.csv');
    Route::get('/reports/attendance/xlsx', [DashboardController::class, 'exportXlsx'])->name('reports.attendance.xlsx');
});
