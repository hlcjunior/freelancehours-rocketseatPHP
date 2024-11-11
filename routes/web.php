<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

/**
 * @see ProjectController::index
 */
Route::get('/', [ProjectController::class,'index'])->name('projects.index');
/**
 * @see ProjectController::show
 */
Route::get('/projects/{project}', [ProjectController::class,'show'])->name('projects.show');

