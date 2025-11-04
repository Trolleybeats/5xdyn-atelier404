<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                        Détails de l'intervention #{{ $intervention->id }}
                    </h2>

                    <div class="flex items-center justify-center space-x-8">
                    @can('update',$intervention)
                        <a href="{{ route('tech.interventions.edit', $intervention) }}"
                            class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-[#60A5FA] transition mb-4 inline-block">
                            Modifier l'intervention
                        </a>
                    @endcan
                    </div>

                    <div class="bg-gray-100 p-4 rounded-lg mb-6">
                        <h3 class="font-semibold text-lg mb-3">Informations sur l'intervention</h3>
                        <p><strong>Statut:</strong> {{ $intervention->statut }}</p>
                        <p><strong>Priorité:</strong> {{ $intervention->priorite }}</p>
                        <p><strong>Type d'appareil:</strong> {{ $intervention->typeAppareil->nom }}</p>
                        <p><strong>Date prévue:</strong> {{ \Illuminate\Support\Carbon::parse($intervention->date_prevue)->format('d/m/Y') }}</p>
                        <p><strong>Description:</strong> {{ $intervention->description }}</p>
                    </div>

                    <div class="bg-gray-100 p-4 rounded-lg">
                        <h3 class="font-semibold text-lg mb-3">Notes associées</h3>
                        @if ($notes->count() > 0)
                            <ul class="space-y-4">
                                @foreach ($notes as $note)
                                    <li class="border-b pb-2">
                                        <p class="text-sm text-gray-600">
                                            <strong>{{ $note->user->name }}</strong> - 
                                            {{ \Illuminate\Support\Carbon::parse($note->created_at)->format('d/m/Y H:i') }}
                                        </p>
                                        <p class="mt-1">{{ $note->contenu }}</p>

                                        <div class="flex justify-end">
                                @can('delete', $note)
                                    <button x-data="{ id: {{ $note->id }} }"
                                        x-on:click.prevent="window.selected = id; $dispatch('open-modal', 'confirm-note-deletion');"
                                        type="submit" class="font-bold bg-white text-gray-700 px-4 py-2 rounded shadow">
                                        <x-heroicon-o-trash class="h-5 w-5 text-red-500" />
                                    </button>
                                @endcan
                                        </div>
                                    </li>
                                    
                                @endforeach
                            </ul>
                            
                        @else
                            <p class="text-gray-600">Aucune note associée.</p>
                        @endif
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
    </div>
</x-app-layout>