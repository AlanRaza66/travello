<x-app-layout>
    <x-container>
        {{-- Upper part of profile --}}
        <div class="flex flex-col justify-start gap-6 mx-4 mt-4 lg:flex-row lg:items-center lg:justify-center lg:mt-0">
            <div class="flex flex-wrap items-center justify-start gap-2">
                <div class="h-[87px] w-[87px] md:h-[166px] md:w-[166px] rounded-[50%] overflow-hidden">
                    @if ($user->picture !== null)
                        <img src={{ asset($user->picture) }} alt="{{ $user->name }}" width="166" height="166"
                            class="object-contain object-center w-full h-full" />
                    @else
                        <img src={{ asset('/avatar.jpg') }} alt="Photo de profile vide" width="166" height="166"
                            class="object-contain object-center w-full h-full" />
                    @endif
                </div>
                <h1 class="inline text-lg font-bold lg:hidden">{{ $user->name }}</h1>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h1 class="hidden text-lg font-bold lg:inline">{{ $user->name }}</h1>
                    <a href="{{ route('profile.edit') }}">
                        <x-primary-button>Modifier mon profil</x-primary-button>
                    </a>
                    <x-primary-button>Archives</x-primary-button>
                </div>
                <div class="flex items-center gap-2 mt-4">
                    <p><span class="font-bold">0</span> publication</p>
                    <p><span class="font-bold">{{ $user->following()->count() }}</span> suivi(e)s</p>
                    <p><span class="font-bold">{{ $user->followers()->count() }}</span> followers</p>
                </div>
                <div>
                    <p>
                        {{ $user->bio }}
                    </p>
                </div>
            </div>
        </div>

        @if (count($doYouKnow) > 0)
            <div class="flex-col items-center hidden w-full px-4 lg:flex">
                <div class="w-3/4 h-[1px] my-2 lg:my-4 bg-gray-400"></div>
                <h3 class="pt-3 pb-4 font-bold">Tu pourrais les connaître</h3>
                <div class="flex items-center justify-center w-full gap-4 pb-4">
                    @foreach ($doYouKnow as $profile)
                        <x-small-profile :profile="$profile"/>
                    @endforeach
                </div>
                <div class="w-3/4 h-[1px] my-2 lg:my-4 bg-gray-400"></div>
            </div>
        @endif
        {{-- Post gallery --}}
        <x-posts-gallery :posts="$user->posts"/>
    </x-container>
</x-app-layout>
