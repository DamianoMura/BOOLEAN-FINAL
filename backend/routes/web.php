<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UpdateRole;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\devCheck;

// this application is only for authenticated users so the welcome page is not needed
Route::get('/', function () {
    return redirect('/login'); //da reinserire una volta il progetto react è pronto all'uso
    // return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'deploy'])->middleware(['auth', 'verified'])->name('dashboard');
Route::put('/dashboard', [UpdateRole::class, 'update'])->middleware([DevCheck::class])->name('dashboard.role-update');





Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');


    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
