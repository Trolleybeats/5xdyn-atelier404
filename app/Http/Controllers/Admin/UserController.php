<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
    Gate::authorize('viewAny', User::class);
    // On récupère tous les utilisateurs avec pagination de 10 par page
    $users = User::paginate(10);

    // On passe les utilisateurs à la vue `admin.users.index`
    return view('admin.users.index', [
        'users' => $users,
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', User::class);
        // On affiche le formulaire de création d'un utilisateur
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,technicien',
        ]);
        User::create($validated);
        return redirect()->route('login')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        Gate::authorize('update', $user);
        // On passe l'utilisateur à la vue `admin.users.edit`
        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validation des données
        $validated = $request->validate([
            'role' => 'required|in:admin,technicien',
        ]);

        // Mise à jour du rôle de l'utilisateur
        $user->role = $validated['role'];
        $user->save();

        // Redirection vers la liste des utilisateurs avec un message de succès
        return redirect()->route('admin.users.index')->with('success', 'Rôle utilisateur mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);
        // Suppression de l'utilisateur
        $user->delete();

        // Redirection vers la liste des utilisateurs avec un message de succès
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
