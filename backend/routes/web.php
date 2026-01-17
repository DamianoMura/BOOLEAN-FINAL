<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UpdateRole;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\devCheck;
use App\Http\Middleware\RoleCheck;








Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'deploy'])->name('dashboard')->middleware([RoleCheck::class]);


    //route per l'aggiornamento dei ruoli
    Route::put('/dashboard', [UpdateRole::class, 'update'])->name('dashboard.role-update');

    Route::resource('/projects', ProjectController::class)->middleware([RoleCheck::class]);

    Route::put('/projects', [ProjectController::class, 'manageEditor'])->name('projects.manageEditor');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');


    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Route pubbliche
Route::get('/explore', [ProjectController::class, 'publicIndex'])->name('projects.public');
require __DIR__ . '/auth.php';
