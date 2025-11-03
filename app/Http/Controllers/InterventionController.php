<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Intervention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class InterventionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        Gate::authorize('viewOwn', Intervention::class);
        $interventions = Intervention::whereHas('derniereAttribution', function ($query) {
            $query->where('user_id', auth()->id());
        })
            ->with(['typeAppareil', 'client', 'derniereAttribution.user'])
            ->paginate(15);
        return view('tech.interventions.index', [
            'interventions' => $interventions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //


        $validatedClient = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'telephone' => 'required|string|max:20',
            'adresse' => 'nullable|string|max:255',
        ]);
        if ($client = Client::where('email', $validatedClient['email'])->first()) {
        } else {
            $client = Client::create($validatedClient);
        }

        $validatedIntervention = $request->validate([
            'description' => 'required|string',
            'typeAppareil' => 'required|exists:type_appareils,id',
        ]);

        $intervention = Intervention::create([
            'description' => $validatedIntervention['description'],
            'statut' => 'Nouvelle_demande',
            'date_prevue' => null,
            'priorite' => 'moyenne',
            'type_appareil_id' => $validatedIntervention['typeAppareil'],
            'client_id' => $client->id,
        ]);

        return redirect()->route('welcome')->with('success', 'Votre demande d\'intervention a été enregistrée avec succès! Nous vous recontacterons bientôt.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Intervention $intervention)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Intervention $intervention)
    {
        //
        Gate::authorize('update', $intervention);
        return view('tech.interventions.edit', [
            'intervention' => $intervention,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Intervention $intervention)
    {
        //
        $validatedData = $request->validate([
            'statut' => 'required|in:Nouvelle_demande,Diagnostic,En_réparations,Terminé,Non_réparable',
            'priorite' => 'required|in:faible,moyenne,elevee,critique',
            'date_prevue' => 'nullable|date',
            'description' => 'required|string',
        ]);
        $intervention->update($validatedData);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Intervention $intervention)
    {
        //
    }
}
