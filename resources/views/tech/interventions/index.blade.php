<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Interventions') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-4 sm:p-6 lg:px-20 bg-white border-b border-gray-200">
                    <!-- Header responsive -->
                    <div
                        class="flex flex-col sm:flex-row justify-between items-start sm:items-center mt-4 sm:mt-8 space-y-4 sm:space-y-0">
                        <div class="text-xl sm:text-2xl font-semibold text-gray-800"> Interventions de {{$user->name}}</div>
                    </div>

                    <div class="mt-6">
                        <!-- Version desktop (tableau) -->
                        <div class="hidden md:block overflow-x-auto">
                            <table class="table-auto w-full">
                                <thead>
                                    <tr class="uppercase text-left bg-gray-50">
                                        <th class="px-4 py-3 border text-xs font-semibold text-gray-600">statut</th>
                                        <th class="px-4 py-3 border text-xs font-semibold text-gray-600">priorité</th>
                                        <th class="px-4 py-3 border text-xs font-semibold text-gray-600">Appareil</th>
                                        <th class="px-4 py-3 border text-xs font-semibold text-gray-600">Date prévue
                                        </th>
                                        <th class="px-4 py-3 border text-xs font-semibold text-gray-600">Client</th>
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
                            {{ $intervention->statut === 'Nouvelle_demande' ? 'bg-purple-100 text-purple-800' : '' }}
                             {{ $intervention->statut === 'Diagnostic' ? 'bg-blue-100 text-blue-800' : '' }}
                             {{ $intervention->statut === 'En_réparations' ? 'bg-teal-100 text-teal-800' : '' }}
                             {{ $intervention->statut === 'Terminé' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $intervention->statut === 'Non_réparable' ? 'bg-fuchsia-100 text-fuchsia-800' : '' }}">
                                                    {{ $intervention->statut === 'Nouvelle_demande' ? 'Nouvelle demande' : '' }}
                                                    {{ $intervention->statut === 'Diagnostic' ? 'Diagnostic' : '' }}
                                                    {{ $intervention->statut === 'En_réparations' ? 'En réparations' : '' }}
                                                    {{ $intervention->statut === 'Terminé' ? 'terminé' : '' }}
                                                    {{ $intervention->statut === 'Non_réparable' ? 'non réparable' : '' }}
                                                </span>
                                            </td>
                                            <td class="border px-4 py-3">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $intervention->priorite === 'faible' ? 'bg-lime-100 text-lime-800' : '' }}
                             {{ $intervention->priorite === 'moyenne' ? 'bg-yellow-100 text-yellow-800' : '' }}
                             {{ $intervention->priorite === 'eleve' ? 'bg-orange-100 text-orange-800' : '' }}
                            {{ $intervention->priorite === 'critique' ? 'bg-red-100 text-red-800' : '' }}">
                                                    {{ $intervention->priorite === 'faible' ? 'faible' : '' }}
                                                    {{ $intervention->priorite === 'moyenne' ? 'moyenne' : '' }}
                                                    {{ $intervention->priorite === 'eleve' ? 'élevée' : '' }}
                                                    {{ $intervention->priorite === 'critique' ? 'critique' : '' }}
                                                </span>
                                            </td>
                                            <td class="border px-4 py-3 text-gray-600">
                                                {{ $intervention->typeAppareil->nom }}</td>
                                            <td class="border px-4 py-3 text-gray-600">
                                                {{ \Illuminate\Support\Carbon::parse($intervention->date_prevue)->format('d/m/Y') }}
                                            </td>
                                            <td class="border px-4 py-3 text-gray-600">
                                                 {{ $intervention->client->nom  }}
                                            </td>
                                            <td class="border px-4 py-3">
                                                <div class="flex justify-center space-x-3"><a
                                                        href="{{ route('tech.interventions.show', $intervention) }}"
                                                        class="text-green-600">
                                                        Détails
                                                    </a>
                                                    <a href="{{ route('tech.interventions.edit', $intervention) }}"
                                                        class="text-blue-500 hover:text-blue-700 font-medium text-sm transition">
                                                        Modifier
                                                    </a>
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
                                            <p class="text-sm font-semibold text-gray-900">
                                                {{ $intervention->typeAppareil->nom }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ \Illuminate\Support\Carbon::parse($intervention->date_prevue)->format('d/m/Y') }}
                                            </p>
                                            <p class="text-xs text-gray-600 mt-1">
                                                {{ $intervention->client->nom  }}
                                            </p>
                                        </div>
                                        <div class="flex flex-col space-y-1 ml-2">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $intervention->statut === 'Nouvelle_demande' ? 'bg-purple-100 text-purple-800' : '' }}
                                            {{ $intervention->statut === 'Diagnostic' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $intervention->statut === 'En_réparations' ? 'bg-teal-100 text-teal-800' : '' }}
                                            {{ $intervention->statut === 'Terminé' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $intervention->statut === 'Non_réparable' ? 'bg-fuchsia-100 text-fuchsia-800' : '' }}">
                                                {{ $intervention->statut === 'Nouvelle_demande' ? 'Nouvelle demande' : '' }}
                                                {{ $intervention->statut === 'Diagnostic' ? 'Diagnostic' : '' }}
                                                {{ $intervention->statut === 'En_réparations' ? 'En réparations' : '' }}
                                                {{ $intervention->statut === 'Terminé' ? 'terminé' : '' }}
                                                {{ $intervention->statut === 'Non_réparable' ? 'non réparable' : '' }}
                                            </span>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
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


                                        <div class="flex space-x-2 pt-3 border-t border-gray-100">
                                            <a href="{{ route('tech.interventions.edit', $intervention) }}"
                                                class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 text-center py-2 px-3 rounded-md text-sm font-medium transition">
                                                Modifier
                                            </a>
                                            <a
                        href="{{ route('tech.interventions.show', $intervention) }}"
                        class="text-green-600 flex-1 bg-green-50 hover:bg-green-100 text-center py-2 px-3 rounded-md text-sm font-medium transition"
                      >
                        Détails
                      </a>
                                        </div>
                                    </div>
                            @endforeach
                        </div>

                        <!-- Pagination responsive -->
                        <div class="mt-6">{{ $interventions->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
