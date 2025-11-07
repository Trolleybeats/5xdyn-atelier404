<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Utilisateurs') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="flex justify-between mt-8">
                <div class=" text-2xl">
                    Détails de l'utilisateur
                </div>
            </div>



            <div class="flex text-gray-500">

                <dl class="mt-6 space-y-6">
                    <div class="flex space-x-4">
                        <dt class="text-sm font-medium text-gray-500 w-20 text-right">
                            Nom
                        </dt>
                        <dd class="text-sm text-gray-900">
                            {{ $user->name }}
                        </dd>
                    </div>
                    <div class="flex space-x-4">
                        <dt class="text-sm font-medium text-gray-500 w-20 text-right">
                            Email
                        </dt>
                        <dd class="text-sm text-gray-900">
                            {{ $user->email }}
                        </dd>
                    </div>
                    <div class="flex space-x-4">
                        <dt class="text-sm font-medium text-gray-500 w-20 text-right">
                            Rôle
                        </dt>
                        <dd class="text-sm text-gray-900">
                            {{ $user->role }}
                        </dd>
                    </div>

                </dl>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="flex justify-between mt-8">
                <div class=" text-l">
                    Nombre d'interventions
                </div>
            </div>





            <div class="mt-6 flex flex-row justify-around ">



                <p class="text-sm bg-violet-200 rounded-md p-2 text-gray-900 space-x-6">
                    <span class=" text-violet-700 font-semibold"> {{ $user->nbInterventionsEnCours() }}</span>  En cours

                </p>


                <p class="text-sm bg-green-200 rounded-md p-2 text-gray-900 space-x-6">
                    <span class=" text-green-700 font-semibold">
                    {{ $user->nbInterventionsTerminees() }}</span> Terminée

                </p>

                <p class="text-sm bg-fuchsia-200 rounded-md p-2 text-gray-900 space-x-6">
                    <span class=" text-fuchsia-700 font-semibold">
                    {{ $user->nbInterventionsEchouees() }}</span> Non réparable

                </p>


            </div>

        </div>
    </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="flex justify-between mt-8">
                <div class=" text-2xl">
                    Modifier le rôle de l'utilisateur
                </div>
            </div>

            <div class="text-gray-500">
                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="flex flex-col space-y-4">

                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="role" :value="__('Rôle')" />

                        <select id="role" name="role"
                            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            required>
                            @foreach (['admin', 'technicien'] as $role)
                                <option value="{{ $role }}" {{ $role == $user->role ? 'selected' : '' }}>
                                    {{ $role }}
                                </option>
                            @endforeach
                        </select>

                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button type="submit">
                            {{ __('Modifier') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
