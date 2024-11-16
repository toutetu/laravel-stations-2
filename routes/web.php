<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\Admin\MovieController as AdminMovieController;
use App\Http\Controllers\SheetController;
use App\Http\Controllers\Admin\ScheduleController; 
use App\Http\Controllers\ReservationController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');

Route::get('/sheets', [SheetController::class, 'index']);


Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');

Route::get('/movies/{movie_id}/schedules/{schedule_id}/sheets', [ReservationController::class, 'showSeats'])->name('movies.schedules.sheets');
Route::get('/movies/{movie_id}/schedules/{schedule_id}/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('/reservations/store', [ReservationController::class, 'store'])->name('reservations.store');

Route::prefix('admin')->group(function () {
    Route::get('/movies', [AdminMovieController::class, 'index'])->name('admin.movies.index');
    Route::get('/movies/create', [AdminMovieController::class, 'create'])->name('admin.movies.create');
    Route::post('/movies/store', [AdminMovieController::class, 'store'])->name('admin.movies.store');
    
    Route::get('/movies/{movie}', [AdminMovieController::class, 'show'])->name('admin.movies.show');
    
    Route::patch('/movies/{movie}/update', [AdminMovieController::class, 'update'])->name('admin.movies.update');
    Route::get('/movies/{movie}/edit', [AdminMovieController::class, 'edit'])->name('admin.movies.edit');

    Route::delete('/movies/{movie}/destroy', [AdminMovieController::class, 'destroy'])->name('admin.movies.destroy');

    

    Route::get('/schedules', [ScheduleController::class, 'index'])->name('admin.schedules.index');
    Route::get('/schedules/{id}', [ScheduleController::class, 'show'])->name('admin.schedules.show');
    Route::get('/movies/{id}/schedules/create', [ScheduleController::class, 'create'])->name('admin.schedules.create');
    Route::post('/movies/{id}/schedules/store', [ScheduleController::class, 'store'])->name('admin.schedules.store');
    Route::get('/schedules/{id}/edit', [ScheduleController::class, 'edit'])->name('admin.schedules.edit');
    Route::patch('/schedules/{id}/update', [ScheduleController::class, 'update'])->name('admin.schedules.update');
    Route::delete('/schedules/{id}/destroy', [ScheduleController::class, 'destroy'])->name('admin.schedules.destroy');
    
});

Route::get('/check-schedules', function () {
    $schedules = DB::table('schedules')->get();
    return response()->json($schedules);
});