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
    public function index()
    {
        Gate::authorize('viewAny', Intervention::class);
        $interventions = Intervention::with(['typeAppareil', 'client', 'derniereAttribution.user'])
            ->latest()
            ->paginate(10);
            
        // Charger tous les techniciens pour la liste déroulante
        $techniciens = User::whereIn('role', ['admin', 'technicien'])->get();
        
        return view('admin.interventions.index', [
            'interventions' => $interventions,
            'techniciens' => $techniciens,
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
            $intervention->attributions()->delete();
            
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
