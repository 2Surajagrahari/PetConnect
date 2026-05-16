<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\AdoptionApplicationController;
use App\Http\Controllers\PetCareArticleController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Public Pet Routes — IMPORTANT: /pets/create MUST be before /pets/{pet} to avoid route conflicts
Route::get('/pets', [PetController::class, 'index'])->name('pets.index');

Route::get('/articles', [PetCareArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [PetCareArticleController::class, 'show'])->name('articles.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Adoption Applications
    Route::post('/pets/{pet}/adopt', [AdoptionApplicationController::class, 'store'])->name('applications.store');
    Route::get('/applications', [AdoptionApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/{application}', [AdoptionApplicationController::class, 'show'])->name('applications.show');

    // Appointments (resource, minus edit/update which are handled differently)
    Route::resource('appointments', AppointmentController::class)->except(['edit', 'update']);

    // Admin / Shelter routes
    Route::middleware('can:manage-pets')->group(function () {
        Route::get('/manage/pets', [PetController::class, 'manage'])->name('pets.manage');
        // MUST come before /pets/{pet} wildcard
        Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');
        Route::post('/pets', [PetController::class, 'store'])->name('pets.store');

        Route::patch('/applications/{application}/status', [AdoptionApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
        Route::resource('articles', PetCareArticleController::class)->except(['index', 'show']);
        Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');
    });

    // Pet edit/update/delete — inside auth but separate from manage-pets so only owner can edit their pets
    Route::middleware('can:manage-pets')->group(function () {
        Route::get('/pets/{pet}/edit', [PetController::class, 'edit'])->name('pets.edit');
        Route::put('/pets/{pet}', [PetController::class, 'update'])->name('pets.update');
        Route::delete('/pets/{pet}', [PetController::class, 'destroy'])->name('pets.destroy');
    });
});

// Public pet detail — must come after /pets/create to avoid conflict
Route::get('/pets/{pet}', [PetController::class, 'show'])->name('pets.show');

require __DIR__.'/auth.php';
