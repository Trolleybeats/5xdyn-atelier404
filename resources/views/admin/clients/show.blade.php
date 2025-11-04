<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Client #{{ $client->id }} - {{ $client->nom }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Informations du client --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-semibold">Détails du client</h3>
                        <a href="{{ route('admin.clients.edit', $client) }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                            Modifier
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-lg font-semibold mb-4">Informations personnelles</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="font-medium text-gray-700">Nom :</span>
                                    <span class="text-gray-900">{{ $client->nom }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Email :</span>
                                    <span class="text-gray-900">{{ $client->email }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Téléphone :</span>
                                    <span class="text-gray-900">{{ $client->telephone }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Adresse :</span>
                                    <span class="text-gray-900">{{ $client->adresse }}</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-lg font-semibold mb-4">Statistiques</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="font-medium text-gray-700">Nombre d'interventions :</span>
                                    <span class="text-gray-900 font-semibold">{{ $client->interventions->count() }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Membre depuis :</span>
                                    <span class="text-gray-900">{{ $client->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Liste des interventions --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold mb-4">Interventions</h3>

                    @if($client->interventions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full">
                                <thead>
                                    <tr class="uppercase text-left text-sm">
                                        <th class="px-4 py-2 border bg-gray-50">Date</th>
                                        <th class="px-4 py-2 border bg-gray-50">Appareil</th>
                                        <th class="px-4 py-2 border bg-gray-50">Description</th>
                                        <th class="px-4 py-2 border bg-gray-50">Statut</th>
                                        <th class="px-4 py-2 border bg-gray-50">Technicien</th>
                                        <th class="px-4 py-2 border bg-gray-50">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($client->interventions as $intervention)
                                    <tr class="hover:bg-gray-50 odd:bg-gray-100 hover:odd:bg-gray-200 transition">
                                        <td class="border px-4 py-2">
                                            {{ $intervention->date_prevue ? \Carbon\Carbon::parse($intervention->date_prevue)->format('d/m/Y') : "Non définie" }}
                                        </td>
                                        <td class="border px-4 py-2">{{ $intervention->typeAppareil->nom }}</td>
                                        <td class="border px-4 py-2">{{ Str::limit($intervention->description, 50) }}</td>
                                        <td class="border px-4 py-2">
                                            <span class="px-2 py-1 rounded text-xs font-semibold
                                                {{ $intervention->statut == 'Terminé' ? 'bg-green-100 text-green-800' :
                                                   ($intervention->statut == 'En_réparations' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                                {{ str_replace('_', ' ', $intervention->statut) }}
                                            </span>
                                        </td>
                                        <td class="border px-4 py-2">
                                           <form method="POST" action="{{ route('admin.interventions.attributions.assign', $intervention) }}">
                                                @csrf
                                                <select name="user_id" onchange="this.form.submit()" class="border border-gray-300 rounded px-2 py-1">
                                                    <option value="">Non assigné</option>
                                                    @foreach($techniciens as $technicien)
                                                        <option value="{{ $technicien->id }}" {{ $intervention->derniereAttribution && $intervention->derniereAttribution->user_id == $technicien->id ? 'selected' : '' }}>
                                                            {{ $technicien->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </td>
                                        <td class="border px-4 py-2">
                                            <a href="{{ route('admin.interventions.edit', $intervention) }}"
                                                class="text-blue-400 hover:text-blue-600">
                                                Modifier
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">Aucune intervention trouvée pour ce client.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Bouton retour --}}
            <div class="mt-6">
                <a href="{{ route('admin.clients.index') }}"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition inline-block">
                    ← Retour à la liste
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
