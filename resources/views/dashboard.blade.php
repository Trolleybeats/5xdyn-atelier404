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
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 md:ml-64"> <!-- <-- reserve space for right panel -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @can('viewOwn', [App\Models\Intervention::class, auth()->user()])
            <a href="{{ route('tech.interventions.index') }}" class="group">
                <div class="h-full bg-white border border-gray-200 rounded-xl p-6 shadow-sm 
                            transition-all duration-200 group-hover:shadow-md group-hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900">Mes Interventions</h2>
                        <div class="p-3 border border-gray-300 rounded-full bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 mx-auto text-black"> <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" /> </svg>
                        </div>
                    </div>
                </div>
            </a>
            @endcan

            
            @can('viewAny', App\Models\Intervention::class)
            <a href="{{ route('admin.interventions.index') }}" class="group">
                <div class="h-full bg-white border border-gray-200 rounded-xl p-6 shadow-sm
                            transition-all duration-200 group-hover:shadow-md group-hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900">Gérer les Interventions</h2>
                        <div class="p-3 border border-gray-300 rounded-full bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 mx-auto text-black"> <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" /> </svg>
                        </div>
                    </div>
                </div>
            </a>
            @endcan

            @can('viewAny', App\Models\User::class)
            <a href="{{ route('admin.users.index') }}" class="group">
                <div class="h-full bg-white border border-gray-200 rounded-xl p-6 shadow-sm
                            transition-all duration-200 group-hover:shadow-md group-hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900">Gérer les Utilisateurs</h2>
                        <div class="p-3 border border-gray-300 rounded-full bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 mx-auto text-black"> <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" /> </svg>
                        </div>
                    </div>
                </div>
            </a>
            @endcan

            @can('viewAny', App\Models\Client::class)
            <a href="{{ route('admin.clients.index') }}" class="group">
                <div class="h-full bg-white border border-gray-200 rounded-xl p-6 shadow-sm
                            transition-all duration-200 group-hover:shadow-md group-hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900">Gérer les Clients</h2>
                        <div class="p-3 border border-gray-300 rounded-full bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 mx-auto text-black"> <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" /> </svg>
                        </div>
                    </div>
                </div>
            </a>
            @endcan

        </div>
    </div>
</div>

</x-app-layout>
