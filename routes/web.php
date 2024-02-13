<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectDetailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/project', [ProjectController::class, 'create'])->name('project.register');
    Route::post('/project', [ProjectController::class, 'store'])->name('project.store');
    Route::get('/project/detail', [ProjectDetailController::class, 'index'])->name('project.detail');
    Route::post('/project/detail', [ProjectDetailController::class, 'index'])->name('project.detail');  // postは日付変更時のリクエスト
    Route::get('/project/detail/edit', [ProjectDetailController::class, 'edit'])->name('project.detail.edit');
    Route::post('/project/detail/update', [ProjectDetailController::class, 'update'])->name('project.detail.update');
});

require __DIR__.'/auth.php';
