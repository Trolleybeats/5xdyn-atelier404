<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribution;
use App\Models\Intervention;
use App\Models\User;
use Dom\Attr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class InterventionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Intervention::class);

        $query = Intervention::with(['typeAppareil', 'client', 'derniereAttribution.user'])->latest();

        // Filtre par nom du client (recherche textuelle)
        if ($request->filled('client')) {
            $clientNom = $request->input('client');
            $query->whereHas('client', function ($q) use ($clientNom) {
                $q->where('nom', 'like', "%{$clientNom}%");
            });
        }

        // Filtre par statut exact
        if ($request->filled('statut')) {
            $query->where('statut', $request->input('statut'));
        }

        // Filtre par technicien (attributions)
        if ($request->filled('technicien')) {
            $technicienId = $request->input('technicien');
            if ($technicienId === 'null') {
                // Interventions non assignées
                $query->whereDoesntHave('attributions');
            } else {
                // Interventions assignées à un technicien spécifique
                $query->whereHas('attributions', function ($q) use ($technicienId) {
                    $q->where('user_id', $technicienId);
                });
            }
        }

        // Filtre par type d'appareil
        if ($request->filled('type_appareil')) {
            $query->where('type_appareil_id', $request->input('type_appareil'));
        }

        //Filtre par priorité
        if ($request->filled('priorite')) {
            $query->where('priorite', $request->input('priorite'));
        }

        //Filtre par date prévue
        if ($request->filled('date_prevue')) {
            $query->whereDate('date_prevue', $request->input('date_prevue'));
        }

        $interventions = $query->paginate(10);

        // Charger tous les techniciens pour la liste déroulante
        $techniciens = User::whereIn('role', ['admin', 'technicien'])->get();
        // Charger les types d'appareil pour la sélection
        $types = \App\Models\TypeAppareil::all();
        
        return view('admin.interventions.index', [
            'interventions' => $interventions,
            'techniciens' => $techniciens,
            'types' => $types,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        Gate::authorize('create', Intervention::class);
        return view('admin.interventions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        {

        $intervention = Intervention::findOrFail($id);
        Gate::authorize('viewAny', $intervention);

        $notes = $intervention
            ->notes()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tech.interventions.show', [
            'intervention' => $intervention,
            'notes' => $notes,
        ]);
    }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Intervention $intervention)
    {
        //
        Gate::authorize('update', $intervention);

        // Charger les relations nécessaires
        $intervention->load(['client', 'typeAppareil', 'derniereAttribution.user']);

        // Charger les techniciens pour la liste déroulante
        $techniciens = User::whereIn('role', ['admin', 'technicien'])->get();

        return view('admin.interventions.edit', [
            'intervention' => $intervention,
            'techniciens' => $techniciens,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Intervention $intervention)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Intervention $intervention)
    {
        //
    }

    public function assignIntervention(Request $request, Intervention $intervention)
    {
        // Vérifier que l'utilisateur peut modifier cette intervention
        Gate::authorize('update', $intervention);

        $request->validate([
            'user_id' => 'nullable|exists:users,id',
        ]);

        if ($request->user_id) {
            // Supprimer les anciennes attributions pour cette intervention
            // $intervention->attributions()->delete();

            // Créer une nouvelle attribution
            Attribution::create([
                'intervention_id' => $intervention->id,
                'user_id' => $request->user_id,
            ]);

            return redirect()->back()->with('success', 'Technicien assigné avec succès.');
        } else {
            // Si pas de technicien sélectionné, supprimer les attributions existantes
            $intervention->attributions()->delete();

            return redirect()->back()->with('success', 'Attribution supprimée avec succès.');
        }
    }

    public function updateAttribution(Request $request, Attribution $attribution)
    {
        Gate::authorize('updateAttribution', $attribution);

        return redirect()->back()->with('success', 'Attribution mise à jour avec succès.');
    }

}
