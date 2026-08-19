<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\InboxController;

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
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/inbox', [InboxController::class, 'index'])->name('admin.inbox.index');
    Route::get('/inbox/{visitorId}', [InboxController::class, 'show'])->name('admin.inbox.show');
    Route::get('/inbox/{visitorId}/poll', [InboxController::class, 'poll'])->name('admin.inbox.poll');
    Route::post('/inbox/{visitorId}/reply', [InboxController::class, 'reply'])->name('admin.inbox.reply');
});

require __DIR__.'/auth.php';
