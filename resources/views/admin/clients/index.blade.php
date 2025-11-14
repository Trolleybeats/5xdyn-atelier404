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

    <div class="py-12">
       <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 md:ml-64">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div
                        class="flex flex-col sm:flex-row justify-between items-start sm:items-center mt-4 sm:mt-8 space-y-4 sm:space-y-0">

                        <div class="text-xl sm:text-2xl font-semibold text-gray-800">Liste des Clients</div>


                        <div class="w-full sm:w-auto">
                            <a href="{{ route('admin.clients.create') }}"
                                class="w-full sm:w-auto inline-flex justify-center items-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-200">Ajouter
                                un client
                            </a>
                        </div>
                    </div>

                    <div class="mt-6">
                        <!-- Version desktop (tableau) -->
                        <div class="hidden md:block overflow-x-auto">
                            <table class="table-auto w-full">
                                <thead>
                                    <tr class="uppercase text-left bg-gray-50">
                                        <th class="px-4 py-3 border text-xs font-semibold text-gray-600">nom</th>
                                        <th class="px-4 py-3 border text-xs font-semibold text-gray-600">email</th>
                                        <th class="px-4 py-3 border text-xs font-semibold text-gray-600">téléphone</th>
                                        <th class="px-4 py-3 border text-xs font-semibold text-gray-600">adresse</th>
                                        <th class="px-4 py-3 border text-xs font-semibold text-gray-600 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clients as $client)
                                        <tr class="hover:bg-gray-50 odd:bg-gray-100 hover:odd:bg-gray-200 transition">
                                            <td class="border px-4 py-3 font-medium">{{ $client->nom }}</td>
                                            <td class="border px-4 py-3 text-gray-600">{{ $client->email }}</td>
                                            <td class="border px-4 py-3 text-gray-600">{{ $client->telephone }}</td>
                                            <td class="border px-4 py-3 text-gray-600">{{ $client->adresse }}</td>
                                            <td class="border px-4 py-3">
                                                <div class="flex justify-center space-x-3">
                                                    <a href="{{ route('admin.clients.show', $client) }}"
                                                        class="text-green-500 hover:text-green-700 font-medium text-sm transition">
                                                        Détails
                                                    </a>
                                                    <a href="{{ route('admin.clients.edit', $client) }}"
                                                        class="text-blue-500 hover:text-blue-700 font-medium text-sm transition">
                                                        Modifier
                                                    </a>
                                                    <button x-data="{ id: {{ $client->id }} }"
                                                        x-on:click.prevent="window.selected = id; $dispatch('open-modal', 'confirm-client-deletion');"
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
    @foreach ($clients as $client)
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
        <div class="mb-3">
            <h3 class="text-lg font-semibold text-gray-900">{{ $client->nom }}</h3>
            <p class="text-sm text-gray-600 break-all">{{ $client->email }}</p>
            <p class="text-sm text-gray-600">{{ $client->telephone }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ $client->adresse }}</p>
        </div>

        <div class="flex space-x-2 pt-3 border-t border-gray-100">
            <a href="{{ route('admin.clients.show', $client) }}"
               class="flex-1 bg-green-50 hover:bg-green-100 text-green-600 text-center py-2 px-3 rounded-md text-sm font-medium transition">
                Détails
            </a>
            <a href="{{ route('admin.clients.edit', $client) }}"
               class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 text-center py-2 px-3 rounded-md text-sm font-medium transition">
                Modifier
            </a>
            <button x-data="{ id: {{ $client->id }} }"
              x-on:click.prevent="window.selected = id; $dispatch('open-modal', 'confirm-client-deletion');"
              class="flex-1 bg-red-50 hover:bg-red-100 text-red-600 text-center py-2 px-3 rounded-md text-sm font-medium transition">
                Supprimer
            </button>
        </div>
    </div>
    @endforeach
</div>
                        <div class="mt-4">{{ $clients->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
        <x-modal name="confirm-client-deletion" focusable>
            <form method="post" onsubmit="event.target.action= '/admin/clients/' + window.selected" class="p-6">
                @csrf
                @method('DELETE')

                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Êtes-vous sûr de vouloir supprimer ce client ?
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
