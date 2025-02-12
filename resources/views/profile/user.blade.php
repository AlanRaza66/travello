<x-app-layout>
    <x-container>
        {{-- Upper part of profile --}}
        <div class="flex flex-col justify-start gap-6 mx-4 mt-4 lg:flex-row lg:items-center lg:justify-center lg:mt-0">
            <div class="flex flex-wrap items-center justify-start gap-2">
                <div class="h-[87px] w-[87px] md:h-[166px] md:w-[166px] rounded-[50%] overflow-hidden">
                    @if ($user->picture !== null)
                        <img src={{ asset($user->picture) }} width="166" height="166"
                            class="object-contain object-center w-full h-full" />
                    @else
                        <img src={{ asset('/avatar.jpg') }} width="166" height="166"
                            class="object-contain object-center w-full h-full" />
                    @endif
                </div>
                <h1 class="inline text-lg font-bold lg:hidden">{{ $user->name }}</h1>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h1 class="hidden text-lg font-bold lg:inline">{{ $user->name }}</h1>
                    @if ($isFollowed)
                        <form method="post" action="{{ route('profile.unfollow', ['user' => $user]) }}">
                            @csrf
                            @method('put')
                            <x-secondary-button>Suivi(e)</x-secondary-button>
                        </form>
                    @else
                        <form method="post" action="{{ route('profile.follow', ['user' => $user]) }}">
                            @csrf
                            @method('put')
                            <x-primary-button>Suivre</x-primary-button>
                        </form>
                    @endif
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
        {{-- Post gallery --}}
        <x-posts-gallery :posts="$user->posts"/>
    </x-container>
</x-app-layout>
