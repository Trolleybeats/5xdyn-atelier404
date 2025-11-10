<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier l'intervention #{{ $intervention->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    {{-- Informations client (lecture seule) --}}
                    <div class="bg-gray-100 p-4 rounded-lg mb-6">
                        <h3 class="font-semibold text-lg mb-3">Informations Client</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Nom</p>
                                <p class="font-medium">{{ $intervention->client->nom }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Email</p>
                                <p class="font-medium">{{ $intervention->client->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Téléphone</p>
                                <p class="font-medium">{{ $intervention->client->telephone }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Type d'appareil</p>
                                <p class="font-medium">{{ $intervention->typeAppareil->nom }}</p>
                            </div>


                            <div class="col-span-2">
                                <p class="text-sm text-gray-600">
                                    Description originelle du problème
                                </p>
                                <p
                                    class="w-full rounded-md border-gray-300 bg-white shadow-sm p-1 ">
                                    {{ $intervention->description }}
                                </p>

                            </div>
                        </div>
                    </div>

                    {{-- Formulaire de modification --}}
                    <form method="POST" action="{{ route('tech.interventions.update', $intervention) }}"
                        class="space-y-6">
                        @csrf
                        @method('PATCH')

                        {{-- Statut --}}
                        <div>
                            <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">
                                Statut <span class="text-red-500">*</span>
                            </label>
                            <select name="statut" id="statut" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="Nouvelle_demande"
                                    {{ $intervention->statut == 'Nouvelle_demande' ? 'selected' : '' }}>Nouvelle demande
                                </option>
                                <option value="Diagnostic"
                                    {{ $intervention->statut == 'Diagnostic' ? 'selected' : '' }}>Diagnostic</option>
                                <option value="En_réparations"
                                    {{ $intervention->statut == 'En_réparations' ? 'selected' : '' }}>En réparations
                                </option>
                                <option value="Terminé" {{ $intervention->statut == 'Terminé' ? 'selected' : '' }}>
                                    Terminé</option>
                                <option value="Non_réparable"
                                    {{ $intervention->statut == 'Non_réparable' ? 'selected' : '' }}>Non réparable
                                </option>
                            </select>
                            @error('statut')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Priorité --}}
                        <div>
                            <label for="priorite" class="block text-sm font-medium text-gray-700 mb-2">
                                Priorité <span class="text-red-500">*</span>
                            </label>
                            <select name="priorite" id="priorite" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="faible" {{ $intervention->priorite == 'faible' ? 'selected' : '' }}>
                                    Faible</option>
                                <option value="moyenne" {{ $intervention->priorite == 'moyenne' ? 'selected' : '' }}>
                                    Moyenne</option>
                                <option value="elevee" {{ $intervention->priorite == 'elevee' ? 'selected' : '' }}>
                                    Élevée</option>
                                <option value="critique" {{ $intervention->priorite == 'critique' ? 'selected' : '' }}>
                                    Critique</option>
                            </select>
                            @error('priorite')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Date prévue --}}
                        <div>
                            <label for="date_prevue" class="block text-sm font-medium text-gray-700 mb-2">
                                Date prévue
                            </label>
                            <input type="date" name="date_prevue" id="date_prevue"
                                value="{{ $intervention->date_prevue }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('date_prevue')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>



                        {{-- Boutons d'action --}}
                        <div class="flex items-center justify-end space-x-3 pt-4">
                            <a href="{{ route('tech.interventions.index') }}"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                                Annuler
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                Mettre à jour
                            </button>
                        </div>
                    </form>

                    {{-- Section Notes --}}
                    <div class="mt-8 border-t pt-6">
                        <h3 class="font-semibold text-lg mb-4">Notes techniques</h3>

                        @if ($intervention->notes->count() > 0)
                            <div class="space-y-3 mb-6">
                                @foreach ($intervention->notes as $note)
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex justify-between items-start mb-2">
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $note->user->name ?? 'Utilisateur inconnu' }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ $note->created_at->format('d/m/Y H:i') }}</p>
                                                @can('delete', $note)
                                                <button x-data="{ id: {{ $note->id }} }"
                                                    x-on:click.prevent="window.selected = id; $dispatch('open-modal', 'confirm-note-deletion');"
                                                    type="submit"
                                                    class="font-bold bg-white text-gray-700 px-4 py-2 rounded shadow">
                                                    <x-heroicon-o-trash class="h-5 w-5 text-red-500" />
                                                </button>
                                            @endcan
                                        </div>
                                        <p class="text-gray-700">{{ $note->contenu }}</p>

                                        @if ($note->images->count() > 0)
                            <div class="mt-2 grid grid-cols-2 md:grid-cols-3 gap-2">
                                @foreach ($note->images as $image)
                                    <figure class="aspect-square relative group">
                                        <img src="{{ Storage::url($image->path) }}" 
                                             alt="Image de la note" 
                                             class="w-full h-full object-cover rounded-lg shadow-sm transition-opacity"
                                             onclick="openImageModal('{{ Storage::url($image->path) }}')">
                                             @can('delete', $image)
                                                 <button x-data
                                                     x-on:click.prevent="window.selected = '{{ $image->id }}-{{ $note->id }}'; $dispatch('open-modal', 'confirm-image-deletion');"
                                                     type="submit"
                                                     class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 p-1.5 bg-white bg-opacity-75 hover:bg-opacity-100 shadow-sm hover:shadow">
                                                     <x-heroicon-o-trash class="h-4 w-4 text-red-500" />
                                                 </button>
                                             @endcan
                                    </figure>

                                @endforeach
                            </div>
                        @endif    
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 italic mb-4">Aucune note pour le moment</p>
                        @endif
                        
                        {{-- Formulaire ajout note --}}
                        <form method="POST" action="{{ route('interventions.notes.add', $intervention) }}" class="mt-4" enctype="multipart/form-data">
                            @csrf
                            <label for="contenu" class="block text-sm font-medium text-gray-700 mb-2">
                                Ajouter une note
                            </label>
                            <textarea name="contenu" id="contenu" rows="3" required
                                placeholder="Décrivez les actions effectuées, les observations, etc."
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 mb-3"></textarea>

                            <div class="mb-4">
                                <label for="images" class="block text-sm font-medium text-gray-700 mb-2">
                                    Ajouter des images (optionnelles)
                                </label>
                                <input type="file" name="images[]" id="images" accept="image/*" multiple
                                    class="w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <p class="text-gray-500 text-xs mt-1">Formats acceptés: JPEG, PNG, JPG, GIF. Taille max: 5MB par image. Maximum 5 images.</p>
                            </div>

                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                                Ajouter la note
                            </button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
        <x-modal name="confirm-note-deletion" focusable>
            <form method="post"
                onsubmit="event.target.action= '/interventions/{{ $intervention->id }}/notes/' + window.selected"
                class="p-6">
                @csrf @method('DELETE')

                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Êtes-vous sûr de vouloir supprimer cette note ?
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
        <x-modal name="confirm-image-deletion" focusable>
            <form method="post"
                onsubmit="const [imageId, noteId] = window.selected.split('-'); event.target.action = '/interventions/{{ $intervention->id }}/notes/' + noteId + '/images/' + imageId"
                class="p-6">
                @csrf @method('DELETE')

                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Êtes-vous sûr de vouloir supprimer cette image ?
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Cette action est irréversible. L'image sera supprimée de la note.
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
