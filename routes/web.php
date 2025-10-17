<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Models\Intervention;
use Illuminate\Support\Facades\Route;

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

//Routes pour la gestion des utilisateurs
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    
    // Gestion des utilisateurs (Détails et changement de rôle)
    Route::resource('/users', UserController::class);
});

//Route pour les attributions
/*Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/interventions/{intervention}/assign', [InterventionController::class, 'assignIntervention'])->name('interventions.attributions.assign');

    Route::patch('/interventions/{intervention}/attributions/{attribution}', [InterventionController::class, 'updateAttribution'])->name('interventions.attributions.update');
})*/

require __DIR__.'/auth.php';
