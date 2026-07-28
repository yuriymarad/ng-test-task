<?php

use App\Http\Controllers\AccessLinkController;
use App\Http\Controllers\LuckyDrawController;
use App\Http\Controllers\ParticipantRegistrationController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'welcome')->name('home');

Route::post('participants', [ParticipantRegistrationController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('participants.store');

Route::prefix('l/{accessLink:token}')->name('access-link.')->group(function () {
    Route::get('/', [AccessLinkController::class, 'show'])->name('show');
    Route::post('regenerate', [AccessLinkController::class, 'regenerate'])->name('regenerate');
    Route::delete('/', [AccessLinkController::class, 'destroy'])->name('destroy');
    Route::post('lucky', [LuckyDrawController::class, 'store'])
        ->middleware('throttle:60,1')
        ->name('play');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
