<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Nette\Utils\Paginator;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserTaskController;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::middleware(['auth', 'isadmin'])->group(function () {
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
    Route::resource('tasks', TaskController::class);
    Route::get('/team', [TeamController::class, 'index'])->name('team');
    Route::get('/team/useractivity', [TeamController::class, 'useractivity'])->name('useractivity');

});
Route::middleware('auth')->group(function () {
    Route::get('/userdashboard', [PageController::class, 'userdashboard'])->name('userdashboard');
    Route::get('/user/tasks', [UserTaskController::class, 'index'])->name('user.tasks.index');
    Route::get('/usertasks/{id}/edit', [UserTaskController::class, 'edit'])->name('user.tasks.edit');
    Route::patch('/usertasks/{id}', [UserTaskController::class, 'update'])->name('user.tasks.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/userprofile', [UserProfileController::class, 'index'])->name('userprofile.index');
    Route::get('/userprofile/edit', [UserProfileController::class, 'edit'])->name('userprofile.edit');
    Route::put('/userprofile', [UserProfileController::class, 'update'])->name('userprofile.update');
});

require __DIR__.'/auth.php';
