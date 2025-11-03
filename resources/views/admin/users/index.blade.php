<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Utilisateurs') }}
    </h2>
  </x-slot>

  <div class="py-6 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-4 sm:p-6 lg:px-20 bg-white border-b border-gray-200">
          <!-- Header responsive -->
          <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mt-4 sm:mt-8 space-y-4 sm:space-y-0">
            <div class="text-xl sm:text-2xl font-semibold text-gray-800">Liste des utilisateurs</div>

            <div class="w-full sm:w-auto">
              <a href="{{ route('auth.register') }}"
                 class="w-full sm:w-auto inline-flex justify-center items-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-200">
                <span class="hidden sm:inline">Ajouter un utilisateur</span>
                <span class="sm:hidden">Ajouter</span>
              </a>
            </div>
          </div>

          <div class="mt-6">
            <!-- Version desktop (tableau) -->
            <div class="hidden md:block overflow-x-auto">
              <table class="table-auto w-full">
                <thead>
                  <tr class="uppercase text-left bg-gray-50">
                    <th class="px-4 py-3 border text-xs font-semibold text-gray-600">Nom</th>
                    <th class="px-4 py-3 border text-xs font-semibold text-gray-600">Email</th>
                    <th class="px-4 py-3 border text-xs font-semibold text-gray-600">Rôle</th>
                    <th class="px-4 py-3 border text-xs font-semibold text-gray-600 text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($users as $user)
                  <tr class="hover:bg-gray-50 odd:bg-gray-100 hover:odd:bg-gray-200 transition">
                    <td class="border px-4 py-3 font-medium">{{ $user->name }}</td>
                    <td class="border px-4 py-3 text-gray-600">{{ $user->email }}</td>
                    <td class="border px-4 py-3">
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                        {{ $user->role }}
                      </span>
                    </td>
                    <td class="border px-4 py-3">
                      <div class="flex justify-center space-x-3">
                        <a href="{{ route('admin.users.edit', $user) }}"
                           class="text-blue-500 hover:text-blue-700 font-medium text-sm transition">
                          Modifier
                        </a>
                        <button x-data="{ id: {{ $user->id }} }"
                          x-on:click.prevent="window.selected = id; $dispatch('open-modal', 'confirm-user-deletion');"
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
              @foreach ($users as $user)
              <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                <div class="flex items-start justify-between mb-3">
                  <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-600 break-all">{{ $user->email }}</p>
                  </div>
                  <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                    {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                    {{ $user->role }}
                  </span>
                </div>
                
                <div class="flex space-x-3 pt-3 border-t border-gray-100">
                  <a href="{{ route('admin.users.edit', $user) }}"
                     class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 text-center py-2 px-3 rounded-md text-sm font-medium transition">
                    Modifier
                  </a>
                  <button x-data="{ id: {{ $user->id }} }"
                    x-on:click.prevent="window.selected = id; $dispatch('open-modal', 'confirm-user-deletion');"
                    class="flex-1 bg-red-50 hover:bg-red-100 text-red-600 text-center py-2 px-3 rounded-md text-sm font-medium transition">
                    Supprimer
                  </button>
                </div>
              </div>
              @endforeach
            </div>

            <!-- Pagination responsive -->
            <div class="mt-6">{{ $users->links() }}</div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal responsive -->
    <x-modal name="confirm-user-deletion" focusable>
      <form method="post" onsubmit="event.target.action= '/admin/users/' + window.selected" class="p-4 sm:p-6">
        @csrf
        @method('DELETE')

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          Êtes-vous sûr de vouloir supprimer cet utilisateur ?
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
          Cette action est irréversible. Toutes les données seront supprimées.
        </p>

        <div class="mt-6 flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
          <x-secondary-button x-on:click="$dispatch('close')" class="w-full sm:w-auto justify-center">
            Annuler
          </x-secondary-button>

          <x-danger-button class="w-full sm:w-auto justify-center" type="submit">
            Supprimer
          </x-danger-button>
        </div>
      </form>
    </x-modal>
  </div>
  
</x-app-layout>