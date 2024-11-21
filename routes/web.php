<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\MovieListController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminMovieController;

Route::redirect('/admin/movies', '/admin/movies')->name('dashboard');

Route::middleware(["auth","verified"])->group(function () { 
    Route::get('/admin/movies', [AdminMovieController::class, 'index'])->name('admin.movies.index');
    Route::get('/admin/movies/create', [AdminMovieController::class, 'create'])->name('admin.movies.create');
    Route::post('/admin/movies', [AdminMovieController::class, 'store'])->name('admin.movies.store');
    Route::get('/admin/movies/{id}', [AdminMovieController::class, 'show'])->name('admin.movies.show');
    Route::get('/admin/movies/{id}/edit', [AdminMovieController::class, 'edit'])->name('admin.movies.edit');
    Route::put('/admin/movies/{id}', [AdminMovieController::class, 'update'])->name('admin.movies.update');
    Route::delete('/admin/movies/{id}', [AdminMovieController::class, 'destroy'])->name('admin.movies.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', function () {
    return redirect()->route('movie.index');
});

Route::get('/welcome', function () {
    return view('welcome');
});

// Route::get('/movie', [MovieListController::class,'index'])->name('movie.index');
// Route::get('/movie/create', [MovieListController::class,'create'])->name('movie.create');
// Route::post('/movie', [MovieListController::class,'store'])->name('movie.store');
// Route::get('/movie/{id}', [MovieListController::class,'show'])->name('movie.show');
// Route::get('/movie/{id}/edit', [MovieListController::class,'edit'])->name('movie.edit');
// Route::put('/movie/{id}', [MovieListController::class,'update'])->name('movie.update');
// Route::delete('/movie/{id}', [MovieListController::class,'destroy'])->name('movie.destroy');

Route::resource('movie', MovieListController::class);

require __DIR__.'/auth.php';
