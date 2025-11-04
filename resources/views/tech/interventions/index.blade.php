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
                <tr
                  class="hover:bg-gray-50 odd:bg-gray-100 hover:odd:bg-gray-200 transition"
                >
                  <td class="border px-4 py-2">{{ $intervention->statut }}</td>
                  <td class="border px-4 py-2">{{ $intervention->priorite }}</td>
                  <td class="border px-4 py-2">{{ $intervention->typeAppareil->nom }}</td>
                  <td class="border px-4 py-2">{{ $intervention->date_prevue }} </td>
                  <td class="border px-4 py-2">{{ $intervention->derniereAttribution?->user->name ?? 'Non assigné'}}</td>
                  <td class="border px-4 py-2 space-x-4">
                    <div class="flex space-x-4">
                      <a
                        href="{{ route('tech.interventions.edit', $intervention) }}"
                        class="text-blue-400"
                      >
                        Modifier
                      </a>
                      <a
                        href="{{ route('tech.interventions.show', $intervention) }}"
                        class="text-green-600"
                      >
                        Détails
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
