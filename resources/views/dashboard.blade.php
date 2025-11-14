<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="p-6 text-gray-900">
                    {{ __("Vous êtes connecté!") }}
                </div>
            <div class="flex flex-row justify-between bg-white overflow-hidden shadow-sm sm:rounded-lg">

                @can('viewAny', App\Models\User::class)
                <div class="p-6 text-gray-900">
                    <a href="{{ route('admin.users.index') }}" class="text-blue-500 underline">Gérer les utilisateurs</a>
                </div>
                @endcan

                @can('viewAny', App\Models\Intervention::class)
                <div class="p-6 text-gray-900">
                    <a href="{{ route('admin.interventions.index') }}" class="text-blue-500 underline">Gérer les interventions</a>
                </div>
                @endcan

                 @can('viewOwn', [App\Models\Intervention::class, auth()->user()])
                <div class="p-6 text-gray-900">
                    <a href="{{ route('tech.interventions.index') }}" class="text-blue-500 underline">Mes interventions</a>
                </div>
                @endcan

                @can('viewAny', App\Models\Client::class)
                <div class="p-6 text-gray-900">
                    <a href="{{ route('admin.clients.index') }}" class="text-blue-500 underline">Gérer les clients</a>
                </div>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
