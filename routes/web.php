<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    MovieController,
    SheetController,
    ReservationController
};
use App\Http\Controllers\Admin\{
    MovieController as AdminMovieController,
    ScheduleController,
    ReservationController as AdminReservationController
};

// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::prefix('movies')->name('movies.')->group(function () {
    Route::get('/', [MovieController::class, 'index'])->name('index');
    Route::get('/{id}', [MovieController::class, 'show'])->name('show');
    Route::get('/{movie_id}/schedules/{schedule_id}/sheets', [ReservationController::class, 'showSeats'])->name('schedules.sheets');
});

Route::prefix('reservations')->name('reservations.')->group(function () {
    Route::get('/create/{movie_id}/{schedule_id}', [ReservationController::class, 'create'])->name('create');
    Route::post('/', [ReservationController::class, 'store'])->name('store');
});

Route::get('/sheets', [SheetController::class, 'index'])->name('sheets');

// Admin routes
// Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resources([
        'movies' => AdminMovieController::class,
        'schedules' => ScheduleController::class,
        'reservations' => AdminReservationController::class,
    ]);

    // Custom routes for schedules
    Route::get('movies/schedules/create', [ScheduleController::class, 'create'])->name('schedules.create');
    Route::post('movies/{id}/schedules', [ScheduleController::class, 'store'])->name('schedules.store');
});

// Debug route
Route::get('/check-schedules', function () {
    return response()->json(DB::table('schedules')->get());
});