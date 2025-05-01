<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/todo', [TodoController::class, 'index'])->name('todo.index');
    Route::get('/todo', [TodoController::class, 'store'])->name('todo.store');
    Route::patch('/todo/create', [TodoController::class, 'update'])->name('todo.create');
    Route::delete('/todo', [TodoController::class, 'edit'])->name('todo.edit');

    Route::get('/todo/{todo}/edit', [TodoCOntroller::class, 'edit'])->name('todo.edit');
    Route::patch('/todo/{todo}', [TodoCOntroller::class, 'update'])->name('todo.update');
    
    Route::patch('/todo/{todo}/complete', [TodoCOntroller::class, 'complete'])->name('todo.complete');
    Route::patch('/todo/{todo}/incomplete', [TodoCOntroller::class, 'uncomplete'])->name('todo.uncomplete');
    
    
    Route::delete('/todo/{todo}', [TodoCOntroller::class, 'destroy'])->name('todo.destroy');
    Route::delete('/todo', [TodoCOntroller::class, 'destroyCompleted'])->name('todo.deleteallcompleted');


    
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::patch('/user/{user}/makeadmin', [UserController::class, 'makeadmin'])->name('user.makeadmin');
    Route::patch('/user/{user}/removeadmin', [UserController::class, 'removeadmin'])->name('user.removeadmin');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    Route::resource('todo', TodoController::class)->except(['show']);
});

require __DIR__.'/auth.php';
