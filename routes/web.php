<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\TypeController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    Route::get('/task', [TaskController::class, 'index'])->name('task.index');
    Route::get('/task/dashboard', [TaskController::class, 'dashboard'])->name('task.dashboard');
    Route::get('/task/history', [TaskController::class, 'history'])->name('task.history');
    Route::get('/task/pending', [TaskController::class, 'pending'])->name('task.pending');
    Route::get('/task/completed', [TaskController::class, 'completed'])->name('task.completed');
    Route::get('/task/create',[TaskController::class, 'create'])->name('task.create');
    Route::post('/task', [TaskController::class, 'store'])->name('task.store');
    Route::get('/task/{task}/edit',[TaskController::class, 'edit'])->name('task.edit');
    Route::post('/task/{task}',[TaskController::class, 'update'])->name('task.update');
    Route::delete('/task/{task}', [TaskController::class, 'destroy'])->name('task.delete');
    Route::patch('/tasks/{id}/status', [TaskController::class, 'updateStatus'])->name('tasks.status');

    Route::get('/type', [TypeController::class, 'index'])->name('type.index');
    Route::get('/type/create',[TypeController::class, 'create'])->name('type.create');
    Route::post('/type', [TypeController::class, 'store'])->name('type.store');
    Route::get('/type/{type}/edit',[TypeController::class, 'edit'])->name('type.edit');
    Route::post('/type/{type}',[TypeController::class, 'update'])->name('type.update');
    Route::delete('/type/{type}', [TypeController::class, 'destroy'])->name('type.delete');


});

require __DIR__.'/settings.php';
