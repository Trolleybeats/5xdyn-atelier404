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
                    <div class="flex justify-between mt-8">
                        <div class="text-2xl">Liste des Interventions</div>

                        {{-- <div class="flex  items-center justify-center space-x-8">
                            <a href="{{ route('auth.register') }}"
                                class="text-gray-500 font-bold py-2 px-4 rounded hover:bg-gray-200 transition">Ajouter un
                                utilisateur</a>
                        </div> --}}
                    </div>

                    <div class="mt-6 text-gray-500">
                        <table class="table-auto w-full">
                            <thead>
                                <tr class="uppercase text-left">
                                    <th class="px-4 py-2 border">statut</th>
                                    <th class="px-4 py-2 border">priorite</th>
                                    <th class="px-4 py-2 border">Appareil</th>
                                    <th class="px-4 py-2 border">Date prévue</th>
                                    <th class="px-4 py-2 border">Technicien</th>
                                    <th class="px-4 py-2 border">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($interventions as $intervention)
                                    <tr class="hover:bg-gray-50 odd:bg-gray-100 hover:odd:bg-gray-200 transition">
                                        <td class="border px-4 py-2">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ $intervention->statut === 'Nouvelle_demande' ? 'bg-purple-100 text-purple-800  ' : '' }}
                         {{ $intervention->statut === 'Diagnostic' ? 'bg-blue-100 text-blue-800 ' : '' }}
                         {{ $intervention->statut === 'En_réparations' ? 'bg-teal-100 text-teal-800 ' : '' }}
                         {{ $intervention->statut === 'Terminé' ? 'bg-green-100 text-green-800 ' : '' }}
                        {{ $intervention->statut === 'Non_réparable' ? 'bg-fuchsia-100 text-fuchsia-800  ' : '' }}">
                                                {{ $intervention->statut === 'Nouvelle_demande' ? 'Nouvelle demande' : '' }}
                                                {{ $intervention->statut === 'Diagnostic' ? 'Diagnostic' : '' }}
                                                {{ $intervention->statut === 'En_réparations' ? 'En réparations' : '' }}
                                                {{ $intervention->statut === 'Terminé' ? 'terminé' : '' }}
                                                {{ $intervention->statut === 'Non_réparable' ? 'non réparable' : '' }}
                                            </span>
                                        </td>
                                        <td class="border
                                                px-4 py-2">
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
                                        <td class="border px-4 py-2">{{ $intervention->typeAppareil->nom }}</td>
                                        <td class="border px-4 py-2">{{ $intervention->date_prevue }} </td>
                                        <td class="border px-4 py-2">
                                            {{ $intervention->derniereAttribution?->user->name ?? 'Non assigné' }}</td>
                                        <td class="border px-4 py-2 space-x-4">
                                            <div class="flex space-x-4">
                                                <a href="{{ route('tech.interventions.edit', $intervention) }}"
                                                    class="text-blue-400">
                                                    Modifier
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">{{ $interventions->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
