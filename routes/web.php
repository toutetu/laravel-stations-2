<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\Admin\MovieController as AdminMovieController;
use App\Http\Controllers\SheetController;

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

Route::prefix('admin')->group(function () {
    Route::get('/movies', [AdminMovieController::class, 'index'])->name('admin.movies.index');
    Route::get('/movies/create', [AdminMovieController::class, 'create'])->name('admin.movies.create');
    Route::post('/movies/store', [AdminMovieController::class, 'store'])->name('admin.movies.store');
    
    Route::get('/movies/{movie}', [AdminMovieController::class, 'show'])->name('admin.movies.show');
    
    Route::patch('/movies/{movie}/update', [AdminMovieController::class, 'update'])->name('admin.movies.update');
    Route::get('/movies/{movie}/edit', [AdminMovieController::class, 'edit'])->name('admin.movies.edit');

    Route::delete('/movies/{movie}/destroy', [AdminMovieController::class, 'destroy'])->name('admin.movies.destroy');
    
});