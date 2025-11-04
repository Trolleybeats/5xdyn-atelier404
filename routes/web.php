<?php


use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\InterventionController as AdminInterventionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InterventionController;
use App\Models\Intervention;
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

    // Gestion des interventions (Vue admin)
    Route::resource('/interventions', AdminInterventionController::class);

    Route::post('/interventions/{intervention}/assign', [AdminInterventionController::class, 'assignIntervention'])->name('interventions.attributions.assign');
    Route::patch('/interventions/{intervention}/attributions/{attribution}', [AdminInterventionController::class, 'updateAttribution'])->name('interventions.attributions.update');
});

//Routes pour la gestion des interventions (Vue technicien)
Route::middleware(['auth', 'verified'])->prefix('tech')->name('tech.')->group(function () {
    Route::resource('/interventions', InterventionController::class);
});

//Routes pour la gestion des interventions (Vue admin)
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('/interventions', AdminInterventionController::class);
});

//Routes pour les clients
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('/clients', \App\Http\Controllers\Admin\ClientController::class);
});


//Routes pour la gestion des interventions (Vue technicien)
Route::middleware(['auth', 'verified'])->prefix('tech')->name('tech.')->group(function () {
    Route::resource('/interventions', InterventionController::class)->only(['index', 'show', 'edit', 'update']);
});


//Routes pour les notes
Route::middleware(['auth'])->group(function () {
    Route::post('/interventions/{intervention}/notes', [InterventionController::class, 'addNote'])->name('interventions.notes.add');
    Route::delete('/interventions/{intervention}/notes/{note}', [InterventionController::class, 'deleteNote'])->name('interventions.notes.delete');
});

//Routes pour les images
/*Route::post('/interventions/{intervention}/images', [ImageController::class, 'addImage'])->name('interventions.images.add');*/

require __DIR__ . '/auth.php';
