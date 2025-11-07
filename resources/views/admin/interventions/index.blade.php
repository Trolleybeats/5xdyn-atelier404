<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Interventions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div
                        class="flex flex-col sm:flex-row justify-between items-start sm:items-center mt-4 sm:mt-8 space-y-4 sm:space-y-0">
                        <div class="text-xl sm:text-2xl font-semibold text-gray-800">Liste des Interventions</div>

                        <div class="w-full sm:w-auto">
                            <a href="{{ route('admin.interventions.create') }}"
                                class="w-full sm:w-auto inline-flex justify-center items-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-200">
                                Ajouter une intervention
                            </a>
                        </div>
                    </div>

                    <div class="mt-6" >
                        <!-- Barre de recherche -->
                        <button onclick="this.nextElementSibling.classList.toggle('hidden');" class="mb-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-200">Filtre avancé</button>
                        <form method="GET" action="{{ route('admin.interventions.index') }}" class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-3 hidden">
                            <div>
                                <label class="sr-only">Client</label>
                                <input type="text" name="client" value="{{ request('client') }}" placeholder="Client (nom)"
                                    class="w-full border rounded px-3 py-2" />
                            </div>

                            <div>
                                <label class="sr-only">Statut</label>
                                <select name="statut" class="w-full border rounded px-3 py-2">
                                    <option value="">Tous statuts</option>
                                    <option value="Nouvelle_demande" {{ request('statut')=='Nouvelle_demande' ? 'selected' : '' }}>Nouvelle demande</option>
                                    <option value="Diagnostic" {{ request('statut')=='Diagnostic' ? 'selected' : '' }}>Diagnostic</option>
                                    <option value="En_réparations" {{ request('statut')=='En_réparations' ? 'selected' : '' }}>En réparations</option>
                                    <option value="Terminé" {{ request('statut')=='Terminé' ? 'selected' : '' }}>Terminé</option>
                                    <option value="Non_réparable" {{ request('statut')=='Non_réparable' ? 'selected' : '' }}>Non réparable</option>
                                </select>
                            </div>

                            <div>
                                <label class="sr-only">Technicien</label>
                                <select name="technicien" class="w-full border rounded px-3 py-2">
                                    <option value="">Tous techniciens</option>
                                    @foreach($techniciens as $tech)
                                        <option value="{{ $tech->id }}" {{ request('technicien') == $tech->id ? 'selected' : '' }}>{{ $tech->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="sr-only">Type d'appareil</label>
                                <select name="type_appareil" class="w-full border rounded px-3 py-2">
                                    <option value="">Tous types d'appareils</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}" {{ request('type_appareil') == $type->id ? 'selected' : '' }}>{{ $type->nom }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="sr-only">Priorité</label>
                                <select name="priorite" class="w-full border rounded px-3 py-2">
                                    <option value="">Toutes priorités</option>
                                    <option value="faible" {{ request('priorite')=='faible' ? 'selected' : '' }}>Faible</option>
                                    <option value="moyenne" {{ request('priorite')=='moyenne' ? 'selected' : '' }}>Moyenne</option>
                                    <option value="eleve" {{ request('priorite')=='eleve' ? 'selected' : '' }}>Élevée</option>
                                    <option value="critique" {{ request('priorite')=='critique' ? 'selected' : '' }}>Critique</option>
                                </select>
                            </div>

                            <div>
                                <label class="sr-only">Date prévue (à partir de)</label>
                                <input type="date" name="date_prevue_debut" value="{{ request('date_prevue_debut') }}"
                                    class="w-full border rounded px-3 py-2" />
                            </div>

                            <div class="md:col-span-4 flex space-x-2 mt-2">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Rechercher</button>
                                <a href="{{ route('admin.interventions.index') }}" class="px-4 py-2 border rounded">Réinitialiser</a>
                            </div>
                        </form>

                        <!-- Version desktop (tableau) -->
                        <div class="hidden md:block overflow-x-auto">
                            <table class="table-auto w-full">
                                <thead>
                                    <tr class="uppercase text-left bg-gray-50">
                                        <th class="px-4 py-3 border text-xs font-semibold text-gray-600">Statut</th>
                                        <th class="px-4 py-3 border text-xs font-semibold text-gray-600">Priorité</th>
                                        <th class="px-4 py-3 border text-xs font-semibold text-gray-600">Appareil</th>
                                        <th class="px-4 py-3 border text-xs font-semibold text-gray-600">Date prévue
                                        </th>
                                        <th class="px-4 py-3 border text-xs font-semibold text-gray-600">Technicien</th>
                                        <th class="px-4 py-3 border text-xs font-semibold text-gray-600 text-center">
                                            Actions</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($interventions as $intervention)
                                        <tr class="hover:bg-gray-50 odd:bg-gray-100 hover:odd:bg-gray-200 transition">
                                            <td class="border px-4 py-3">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ $intervention->statut === 'Nouvelle_demande' ? 'bg-purple-100 text-purple-800  ' : '' }}
                         {{ $intervention->statut === 'Diagnostic' ? 'bg-blue-100 text-blue-800 ' : '' }}
                         {{ $intervention->statut === 'En_réparations' ? 'bg-teal-100 text-teal-800 ' : '' }}
                         {{ $intervention->statut === 'Terminé' ? 'bg-green-100 text-green-800 ' : '' }}
                        {{ $intervention->statut === 'Non_réparable' ? 'bg-fuchsia-100 text-fuchsia-800  ' : '' }}">
                                                    {{ $intervention->statut === 'Nouvelle_demande' ? 'Nouvelle demande' : '' }}
                                                    {{ $intervention->statut === 'Diagnostic' ? 'Diagnostic' : '' }}
                                                    {{ $intervention->statut === 'En_réparations' ? 'En réparation' : '' }}
                                                    {{ $intervention->statut === 'Terminé' ? 'Terminé' : '' }}
                                                    {{ $intervention->statut === 'Non_réparable' ? 'Non réparable' : '' }}
                                                </span>
                                            </td>
                                            <td
                                                class="border
                                                px-4 py-3">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ $intervention->priorite === 'faible' ? 'bg-lime-100 text-lime-800  ' : '' }}
                         {{ $intervention->priorite === 'moyenne' ? 'bg-yellow-100 text-yellow-800 ' : '' }}
                         {{ $intervention->priorite === 'eleve' ? 'bg-orange-100 text-orange-800 ' : '' }}
                        {{ $intervention->priorite === 'critique' ? 'bg-red-100 text-red-800  ' : '' }}">
                                                    {{ $intervention->priorite === 'faible' ? 'faible' : '' }}
                                                    {{ $intervention->priorite === 'moyenne' ? 'moyenne' : '' }}
                                                    {{ $intervention->priorite === 'eleve' ? 'élevée' : '' }}
                                                    {{ $intervention->priorite === 'critique' ? 'critique' : '' }}
                                                </span>
                                            </td>
                                            <td class="border px-4 py-3">{{ $intervention->typeAppareil->nom }}</td>
                                            <td class="border px-4 py-3">
                                                {{ \Illuminate\Support\Carbon::parse($intervention->date_prevue)->format('d/m/Y') }}
                                            </td>
                                            <td class="border px-4 py-3">
                                                <form method="POST"
                                                    action="{{ route('admin.interventions.attributions.assign', $intervention) }}">
                                                    @csrf
                                                    <select name="user_id" onchange="this.form.submit()"
                                                        class="border border-gray-300 rounded px-2 py-1">
                                                        <option value="">Non assigné</option>
                                                        @foreach ($techniciens as $technicien)
                                                            <option value="{{ $technicien->id }}"
                                                                {{ $intervention->derniereAttribution && $intervention->derniereAttribution->user_id == $technicien->id ? 'selected' : '' }}>
                                                                {{ $technicien->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </form>
                                            </td>
                                            <td class="border px-4 py-3">
                                                <div class="flex justify-center space-x-3">
                                                    <a href="{{ route('tech.interventions.show', $intervention) }}"
                                                    class="text-green-500 hover:text-green-700 font-medium text-sm transition"">
                                                    Détails
                                                </a>
                                                    <a href="{{ route('admin.interventions.edit', $intervention) }}"
                                                        class="text-blue-500 hover:text-blue-700 font-medium text-sm transition">
                                                        Modifier
                                                    </a>
                                                    <button x-data="{ id: {{ $intervention->id }} }"
                                                        x-on:click.prevent="window.selected = id; $dispatch('open-modal', 'confirm-user-deletion');"
                                                        class="text-red-500 hover:text-red-700 font-medium text-sm transition">
                                                        Supprimer
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Version mobile (cartes) -->
                        <div class="md:hidden space-y-4">
                            @foreach ($interventions as $intervention)
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-gray-900">{{ $intervention->typeAppareil->nom }}</p>
                                            <p class="text-xs text-gray-500">{{ \Illuminate\Support\Carbon::parse($intervention->date_prevue)->format('d/m/Y') }}</p>
                                        </div>
                                        <div class="flex flex-col space-y-1 ml-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $intervention->statut === 'Nouvelle_demande' ? 'bg-purple-100 text-purple-800' : '' }}
                                                {{ $intervention->statut === 'Diagnostic' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $intervention->statut === 'En_réparations' ? 'bg-teal-100 text-teal-800' : '' }}
                                                {{ $intervention->statut === 'Terminé' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $intervention->statut === 'Non_réparable' ? 'bg-fuchsia-100 text-fuchsia-800' : '' }}">
                                                {{ $intervention->statut === 'Nouvelle_demande' ? 'Nouvelle demande' : '' }}
                                                {{ $intervention->statut === 'Diagnostic' ? 'Diagnostic' : '' }}
                                                {{ $intervention->statut === 'En_réparations' ? 'En réparation' : '' }}
                                                {{ $intervention->statut === 'Terminé' ? 'Terminé' : '' }}
                                                {{ $intervention->statut === 'Non_réparable' ? 'Non réparable' : '' }}
                                            </span>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $intervention->priorite === 'faible' ? 'bg-lime-100 text-lime-800' : '' }}
                                                {{ $intervention->priorite === 'moyenne' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $intervention->priorite === 'eleve' ? 'bg-orange-100 text-orange-800' : '' }}
                                                {{ $intervention->priorite === 'critique' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ $intervention->priorite === 'faible' ? 'faible' : '' }}
                                                {{ $intervention->priorite === 'moyenne' ? 'moyenne' : '' }}
                                                {{ $intervention->priorite === 'eleve' ? 'élevée' : '' }}
                                                {{ $intervention->priorite === 'critique' ? 'critique' : '' }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <form method="POST"
                                            action="{{ route('admin.interventions.attributions.assign', $intervention) }}">
                                            @csrf
                                            <select name="user_id" onchange="this.form.submit()"
                                                class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                                                <option value="">Non assigné</option>
                                                @foreach ($techniciens as $technicien)
                                                    <option value="{{ $technicien->id }}"
                                                        {{ $intervention->derniereAttribution && $intervention->derniereAttribution->user_id == $technicien->id ? 'selected' : '' }}>
                                                        {{ $technicien->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </div>

                                    <div class="flex space-x-2 pt-3 border-t border-gray-100">
                                        <a href="{{ route('admin.interventions.show', $intervention) }}"
                                            class="flex-1 bg-green-50 hover:bg-green-100 text-green-600 text-center py-2 px-3 rounded-md text-sm font-medium transition">
                                            Détails
                                        </a><a href="{{ route('admin.interventions.edit', $intervention) }}"
                                            class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 text-center py-2 px-3 rounded-md text-sm font-medium transition">
                                            Modifier
                                        </a>
                                        <button x-data="{ id: {{ $intervention->id }} }"
                                            x-on:click.prevent="window.selected = id; $dispatch('open-modal', 'confirm-user-deletion');"
                                            class="flex-1 bg-red-50 hover:bg-red-100 text-red-600 text-center py-2 px-3 rounded-md text-sm font-medium transition">
                                            Supprimer
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">{{ $interventions->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
        <x-modal name="confirm-intervention-deletion" focusable>
            <form method="post" onsubmit="event.target.action= '/admin/intervention/' + window.selected"
                class="p-6">
                @csrf
                @method('DELETE')

                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Êtes-vous sûr de vouloir supprimer cette intervention ?
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Cette action est irréversible. Toutes les données seront supprimées.
                </p>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        Annuler
                    </x-secondary-button>

                    <x-danger-button class="ml-3" type="submit">
                        Supprimer
                    </x-danger-button>
                </div>
            </form>
        </x-modal>
    </div>

</x-app-layout>
