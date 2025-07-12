<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


// Route::middleware('auth')->group(function () {
//     Route::post('/clock-in', [AttendanceController::class, 'clockIn']);
//     Route::post('/clock-out', [AttendanceController::class, 'clockOut']);
// });



Route::middleware(['auth'])->group(function () {
    Route::view('/attendance', 'attendance')->name('attendance.view');
    Route::post('/clock-in', [AttendanceController::class, 'clockIn'])->name('clock.in');
    Route::post('/clock-out', [AttendanceController::class, 'clockOut'])->name('clock.out');
});


// Route::middleware('auth')->group(function () {
//     Route::post('/clock-in', [AttendanceController::class, 'clockIn']);
//     Route::post('/clock-out', [AttendanceController::class, 'clockOut']);
// });
