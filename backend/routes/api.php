<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ProjectController;

Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{slug}', [ProjectController::class, 'show']);
