<x-app-layout>
    <x-container>
        {{-- Upper part of profile --}}
        <div class="flex flex-col justify-start gap-6 mx-4 lg:flex-row lg:items-center lg:justify-center">
            <div class="flex flex-wrap items-center justify-start gap-2">
                <div class="h-[87px] w-[87px] md:h-[166px] md:w-[166px] rounded-[50%] bg-teal-600">

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
        <div class="grid w-full grid-cols-3 gap-[2px] px-1">
            <div class="bg-teal-500 aspect-[1/1] col-span-1"></div>
            <div class="bg-teal-500 aspect-[1/1] col-span-1"></div>
            <div class="bg-teal-500 aspect-[1/1] col-span-1"></div>
            <div class="bg-teal-500 aspect-[1/1] col-span-1"></div>
            <div class="bg-teal-500 aspect-[1/1] col-span-1"></div>
            <div class="bg-teal-500 aspect-[1/1] col-span-1"></div>
            <div class="bg-teal-500 aspect-[1/1] col-span-1"></div>
        </div>
    </x-container>
</x-app-layout>
