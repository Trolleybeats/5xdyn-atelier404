<?php

<<<<<<< Updated upstream
=======
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InterventionController;
>>>>>>> Stashed changes
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
<<<<<<< Updated upstream
});
=======
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/interventions/create', [InterventionController::class, 'create'])->name('interventions.create');
Route::post('/interventions', [InterventionController::class, 'store'])->name('interventions.store');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//Routes pour la gestion des utilisateurs
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {

    // Gestion des utilisateurs (Détails et changement de rôle)
    Route::resource('/users', UserController::class);
});

require __DIR__ . '/auth.php';
>>>>>>> Stashed changes
