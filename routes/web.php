<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\MovieListController;
use Illuminate\Support\Facades\Route;

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