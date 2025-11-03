<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\InterventionController as AdminInterventionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InterventionController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/interventions', [InterventionController::class, 'index'])->name('interventions.index');
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

    Route::resource('/interventions', AdminInterventionController::class);
});


//Routes pour les attributions
/*Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/interventions/{intervention}/assign', [InterventionController::class, 'assignIntervention'])->name('interventions.attributions.assign');

    Route::patch('/interventions/{intervention}/attributions/{attribution}', [InterventionController::class, 'updateAttribution'])->name('interventions.attributions.update');
})*/

//Routes pour les notes
/*Route::middleware(['auth'])->group(function () {
    Route::post('/interventions/{intervention}/notes', [NoteController::class, 'addNote'])->name('interventions.notes.add');
    Route::delete('/interventions/{intervention}/notes/{note}', [NoteController::class, 'deleteNote'])->name('interventions.notes.delete');
});*/

//Routes pour les images
/*Route::post('/interventions/{intervention}/images', [ImageController::class, 'addImage'])->name('interventions.images.add');*/

require __DIR__ . '/auth.php';
