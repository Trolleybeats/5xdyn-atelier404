<nav x-data="{ open: false }" class="bg-white border-gray-200">

    <!-- Sidebar Desktop -->
    <div class="hidden sm:flex w-64 h-screen bg-white border-r border-gray-200 flex-col p-4 fixed">

        <!-- Logo -->
        <div class="shrink-0 flex items-center mb-6">
            <a href="{{ route('dashboard') }}">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
            </a>
        </div>

        <!-- Navigation Links -->
        <div class="flex flex-col space-y-1">

            @can('viewOwn', [App\Models\Intervention::class, auth()->user()])
                <x-nav-link 
                    :href="route('tech.interventions.index')" 
                    :active="request()->routeIs('tech.interventions.*')"
                    class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100"
                >
                    <i class="ri-tools-line mr-3 text-lg"></i>
                    {{ __('Mes Interventions') }}
                </x-nav-link>
            @endcan

            @can('viewAny', App\Models\Intervention::class)
                <x-nav-link 
                    :href="route('admin.interventions.index')" 
                    :active="request()->routeIs('admin.interventions.*')"
                    class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100"
                >
                    <i class="ri-list-check mr-3 text-lg"></i>
                    {{ __('Interventions') }}
                </x-nav-link>
            @endcan

            @can('viewAny', App\Models\User::class)
                <x-nav-link 
                    :href="route('admin.users.index')" 
                    :active="request()->routeIs('admin.users.*')"
                    class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100"
                >
                    <i class="ri-user-3-line mr-3 text-lg"></i>
                    {{ __('Utilisateurs') }}
                </x-nav-link>
            @endcan

            @can('viewAny', App\Models\Client::class)
                <x-nav-link 
                    :href="route('admin.clients.index')" 
                    :active="request()->routeIs('admin.clients.*')"
                    class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100"
                >
                    <i class="ri-group-line mr-3 text-lg"></i>
                    {{ __('Clients') }}
                </x-nav-link>
            @endcan

        </div>

        <!-- User Dropdown (only desktop) -->
        <div class="mt-auto pt-6">
            <x-dropdown align="up" width="48">
                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4
                        font-medium rounded-md text-gray-700 bg-white hover:text-gray-700 focus:outline-none transition">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
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

    </div>

    <!-- Top Bar (mobile) -->
    <div class="sm:hidden border-b border-gray-100 px-4 py-3 flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ route('dashboard') }}">
            <x-application-logo class="block h-8 w-auto fill-current text-gray-800" />
        </a>

        <!-- Hamburger -->
        <button @click="open = ! open"
            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 
            hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100">
            <svg class="h-6 w-6" stroke="currentColor" fill="none">
                <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-white border-b border-gray-200">

        <div class="pt-2 pb-3 space-y-1">
            @can('viewOwn', [App\Models\Intervention::class,Auth::user()])
                <x-responsive-nav-link
                    :href="route('tech.interventions.index')"
                    :active="request()->routeIs('tech.interventions.*')">
                    {{ __('Mes Interventions') }}
                </x-responsive-nav-link>
            @endcan

            @can('viewAny', App\Models\Intervention::class)
                <x-responsive-nav-link
                    :href="route('admin.interventions.index')"
                    :active="request()->routeIs('admin.interventions.*')">
                    {{ __('Interventions') }}
                </x-responsive-nav-link>
            @endcan

            @can('viewAny', App\Models\User::class)
                <x-responsive-nav-link
                    :href="route('admin.users.index')"
                    :active="request()->routeIs('admin.users.*')">
                    {{ __('Utilisateurs') }}
                </x-responsive-nav-link>
            @endcan

            @can('viewAny', App\Models\Client::class)
                <x-responsive-nav-link
                    :href="route('admin.clients.index')"
                    :active="request()->routeIs('admin.clients.*')">
                    {{ __('Clients') }}
                </x-responsive-nav-link>
            @endcan
        </div>

        <!-- Responsive User Menu -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

</nav>
