<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                        Détails de l'intervention #{{ $intervention->id }}
                    </h2>

                    <div class="flex items-center justify-center space-x-8">
                        @can('update', $intervention)
                            <a href="{{ route('tech.interventions.edit', $intervention) }}"
                                class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-[#60A5FA] transition mb-4 inline-block">
                                Modifier l'intervention
                            </a>
                        @endcan
                    </div>
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

                        </div>
                    </div>

                    <div class="bg-gray-100 p-4 rounded-lg mb-6">
                        <h3 class="font-semibold text-lg mb-3">Informations sur l'intervention</h3>
                        <p><strong>Statut:</strong> {{ $intervention->statut }}</p>
                        <p><strong>Priorité:</strong> {{ $intervention->priorite }}</p>
                        <p><strong>Type d'appareil:</strong> {{ $intervention->typeAppareil->nom }}</p>
                        <p><strong>Date prévue:</strong>
                            {{ \Illuminate\Support\Carbon::parse($intervention->date_prevue)->format('d/m/Y') }}</p>
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

                                        @if ($note->images->count() > 0)
                                            <div class="mt-2 grid grid-cols-2 md:grid-cols-3 gap-2">
                                                @foreach ($note->images as $image)
                                                    <figure class="aspect-square">
                                                        <img src="{{ Storage::url($image->path) }}"
                                                            alt="Image de la note"
                                                            class="w-full h-full object-cover rounded-lg shadow-sm">
                                                    </figure>
                                                @endforeach
                                            </div>
                                        @endif
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

    </div>
</x-app-layout>
