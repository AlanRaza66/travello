@php
    $user = Auth::user();
@endphp

{{-- Upper navbar for mobile --}}
<nav class="fixed flex items-center justify-start w-full md:hidden h-[50px] bg-sky-500 z-50" >
    <a class="flex items-center justify-start w-full gap-4 px-3 py-6" href="{{ route('dashboard') }}">
        <x-heroicon-s-map-pin class="w-6 h-6 text-white" />
        <span class="font-bold text-white uppercase">Travello</span>
    </a>
</nav>
{{-- Desktop navbar and bottom navbar for mobile --}}
<nav x-data="{ open: false }"
    class="h-[50px] flex items-center justify-around md:items-start md:justify-start md:flex-col lg:w-[244px] md:w-[72px] md:h-screen fixed md:sticky md:top-0 left-0 bg-sky-500 p-3 md:pb-5 bottom-0 w-full">
    <a class="items-center justify-start hidden w-full gap-4 px-3 py-6 md:flex" href="{{ route('dashboard') }}">
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
    <x-nav-link :href="route('profile.index')" :active="request()->routeIs('profile.*')">
        @if (request()->routeIs('profile.*'))
            <x-heroicon-s-user class="w-6 h-6 lg:mr-3" />
            <p class="hidden lg:inline">{{ __('Profil') }}</p>
        @else
            <x-heroicon-o-user class="w-6 h-6 lg:mr-3" />
            <p class="hidden lg:inline">{{ __('Profil') }}</p>
        @endif
    </x-nav-link>
    <x-nav-link :href="route('post.create', ['user' => $user])" :active="request()->routeIs('post.create')">
        @if (request()->routeIs('post.create', ['user' => $user]))
            <x-heroicon-s-plus-circle class="w-6 h-6 lg:mr-3" />
            <p class="hidden lg:inline">{{ __('Créer') }}</p>
        @else
            <x-heroicon-o-plus-circle class="w-6 h-6 lg:mr-3" />
            <p class="hidden lg:inline">{{ __('Créer') }}</p>
        @endif
    </x-nav-link>
    <form method="POST" action="{{ route('logout') }}" class="lg:w-full">
        @csrf

        <x-nav-link :href="route('logout')"
            onclick="event.preventDefault();
                            this.closest('form').submit();">
            <x-heroicon-o-arrow-right-start-on-rectangle class="w-6 h-6 lg:mr-3" />
            <span class="hidden lg:inline">{{ __('Se déconnecter') }}</span>
        </x-nav-link>
    </form>
</nav>
