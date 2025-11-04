<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nouveau Client
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.clients.store') }}" class="space-y-6">
                        @csrf

                        {{-- Nom --}}
                        <div>
                            <x-input-label for="nom" :value="__('Nom')" />
                            <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom"
                                :value="old('nom')" required />
                            <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                        </div>

                        {{-- Email --}}
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        {{-- Téléphone --}}
                        <div>
                            <x-input-label for="telephone" :value="__('Téléphone')" />
                            <x-text-input id="telephone" class="block mt-1 w-full" type="tel" name="telephone"
                                :value="old('telephone')" required />
                            <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
                        </div>

                        {{-- Adresse --}}
                        <div>
                            <x-input-label for="adresse" :value="__('Adresse')" />
                            <textarea id="adresse" name="adresse" rows="3" required
                                class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('adresse') }}</textarea>
                            <x-input-error :messages="$errors->get('adresse')" class="mt-2" />
                        </div>

                        {{-- Boutons d'action --}}
                        <div class="flex items-center justify-end space-x-3 pt-4">
                            <a href="{{ route('admin.clients.index') }}"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                                Annuler
                            </a>
                            <x-primary-button>
                                Enregistrer
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
