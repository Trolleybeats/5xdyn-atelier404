<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\User;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        Gate::authorize('viewAny', Client::class);
        $clients = Client::paginate(15);
        return view('admin.clients.index', [
            'clients' => $clients,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        Gate::authorize('create', Client::class);
        return view('admin.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients,email',
            'telephone' => 'required|string|max:20',
            'adresse' => 'nullable|string|max:255',
        ]);
        Client::create($validated);
        return redirect()->route('admin.clients.index')->with('success', 'Client créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
        Gate::authorize('view', $client);
         // Charger tous les techniciens pour la liste déroulante
        $techniciens = User::whereIn('role', ['admin', 'technicien'])->get();

        return view('admin.clients.show', [
            'client' => $client,
            'techniciens' => $techniciens,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
        Gate::authorize('update', $client);
        return view('admin.clients.edit', [
            'client' => $client,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        //
        Gate::authorize('update', $client);
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients,email,' . $client->id,
            'telephone' => 'required|string|max:20',
            'adresse' => 'nullable|string|max:255',
        ]);
        $client->update($validated);
        return redirect()->back()->with('success', 'Client mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
        Gate::authorize('delete', $client);
        // Suppression de l'utilisateur
        $client->delete();

        // Redirection vers la liste des utilisateurs avec un message de succès
        return redirect()->route('admin.clients.index')->with('success', 'Client supprimé avec succès.');
    }
}
