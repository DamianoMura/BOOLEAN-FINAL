<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectSectionController;
use App\Http\Controllers\UpdateRole;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\devCheck;
use App\Http\Middleware\RoleCheck;
use App\Models\ProjectSection;

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'deploy'])->name('dashboard')->middleware([RoleCheck::class]);


    //route per l'aggiornamento dei ruoli
    Route::put('/dashboard', [UpdateRole::class, 'update'])->name('dashboard.role-update');


    Route::middleware([RoleCheck::class])->group(function () {
        //projects routes
        Route::resource('/projects', ProjectController::class);
        //
        Route::put('/projects', [ProjectController::class, 'manageEditor'])->name('projects.manageEditor');
        //project-sections routes

        //editors routes 
        Route::post('project-sections', [ProjectSectionController::class, 'store'])->name('project-sections.store');
        Route::delete('project-sections/{projectSection}', [ProjectSectionController::class, 'destroy'])->name('project-sections.destroy');

        Route::put('project-sections/{projectSection}', [ProjectSectionController::class, 'update'])->name('project-sections.update');
    });



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');


    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Route pubbliche
Route::get('/explore', [ProjectController::class, 'publicIndex'])->name('projects.public');
require __DIR__ . '/auth.php';
