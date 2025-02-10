<nav x-data="{ open: false }" class="lg:w-[244px] w-[72px] h-screen sticky top-0 left-0 bg-sky-500 p-3 pb-5">
    <a class="flex items-center justify-start w-full gap-4 px-3 py-6" href="{{ route('dashboard') }}">
        <x-heroicon-s-map-pin class="w-6 h-6 text-white" />
        <span class="hidden font-bold text-white uppercase lg:text-xl lg:inline">Travello</span>
    </a>
    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        @if (request()->routeIs('dashboard'))
            <x-heroicon-s-home class="w-6 h-6 lg:mr-3" />
            <p class="hidden lg:inline">{{ __('Accueil') }}</p>
        @else
            <x-heroicon-o-home class="w-6 h-6 lg:mr-3" />
            <p class="hidden lg:inline">{{ __('Accueil') }}</p>
        @endif
    </x-nav-link>
    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
        @if (request()->routeIs('profile.edit'))
            <x-heroicon-s-user class="w-6 h-6 lg:mr-3" />
            <p class="hidden lg:inline">{{ __('Profil') }}</p>
        @else
            <x-heroicon-o-user class="w-6 h-6 lg:mr-3" />
            <p class="hidden lg:inline">{{ __('Profil') }}</p>
        @endif
    </x-nav-link>
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <x-nav-link :href="route('logout')"
            onclick="event.preventDefault();
                            this.closest('form').submit();">
            <x-heroicon-o-arrow-right-start-on-rectangle class="w-6 h-6 lg:mr-3" />
            <span class="hidden lg:inline">{{ __('Se déconnecter') }}</span>
        </x-nav-link>
    </form>
</nav>
