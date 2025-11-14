<x-app-layout>
     <x-slot name="header">
        <div class="flex items-center justify-end">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white focus:outline-none transition">
                        <span class="px-3 py-1 text-grey-700 rounded-md">{{ Auth::user()->name }}</span>
                        <svg class="ms-2 fill-current h-4 w-4" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 md:ml-64">
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
                                                    {{ $intervention->statut === 'En_réparations' ? 'En réparation' : '' }}
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
                                                {{ $intervention->statut === 'En_réparations' ? 'En réparation' : '' }}
                                                {{ $intervention->statut === 'Terminé' ? 'Terminé' : '' }}
                                                {{ $intervention->statut === 'Non_réparable' ? 'Non réparable' : '' }}
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
                                            <a
                        href="{{ route('tech.interventions.show', $intervention) }}"
                        class="text-green-600 flex-1 bg-green-50 hover:bg-green-100 text-center py-2 px-3 rounded-md text-sm font-medium transition"
                      >
                        Détails
                      </a>
                      <a href="{{ route('tech.interventions.edit', $intervention) }}"
                                                class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 text-center py-2 px-3 rounded-md text-sm font-medium transition">
                                                Modifier
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
