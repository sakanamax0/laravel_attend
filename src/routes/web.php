<?php

use App\Http\Controllers\CarveController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DateController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BreakController;


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');


Route::get('/date/{date?}', [DateController::class, 'show'])->name('date.show');
Route::get('/date/{direction}/{date}', [DateController::class, 'changeDate'])->name('date.change');


Route::get('/carve', [CarveController::class, 'index'])->name('carve');
Route::post('/carve/start-work', [CarveController::class, 'startWork'])->name('start.work');
Route::post('/carve/end-work', [CarveController::class, 'endWork'])->name('end.work');


Route::post('/carve/start-break', [CarveController::class, 'startBreak'])->name('start.break');
Route::post('/carve/end-break', [CarveController::class, 'endBreak'])->name('end.break');

Route::post('/break/start', [BreakController::class, 'start'])->name('break.start');
Route::post('/break/end', [BreakController::class, 'end'])->name('break.end');

Route::resource('attendances', AttendanceController::class)->only(['index', 'store']);
Route::post('attendances/start-break', [AttendanceController::class, 'startBreak'])->name('attendance.startBreak');
Route::post('attendances/end-break', [AttendanceController::class, 'endBreak'])->name('attendance.endBreak');
