<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UpdateRole;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\devCheck;
use App\Http\Middleware\RoleCheck;

// this application is only for authenticated users so the welcome page is not needed
Route::get('/', function () {
    return redirect('/login'); //da reinserire una volta il progetto react è pronto all'uso
    // return view('welcome');
});






Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'deploy'])->name('dashboard')->middleware([RoleCheck::class]);

    Route::resource('/projects', ProjectController::class)->middleware([RoleCheck::class]);

    //route per l'aggiornamento dei ruoli
    Route::put('/projects', [ProjectController::class, 'assignEditor'])->name('projects.assignEditor');
    Route::delete('/projects', [ProjectController::class, 'removeEditor'])->name('projects.removeEditor');
    //built in routes from laravel
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Route pubbliche
Route::get('/explore', [ProjectController::class, 'publicIndex'])->name('projects.public');
require __DIR__ . '/auth.php';
