<x-app-layout>
    <x-container>
        <div class="flex flex-wrap items-start justify-start w-full overflow-hidden bg-white sm:rounded-lg">
            <div class="lg:w-1/2 aspect-square">
                <img src="{{ asset($post->picture) }}" alt="{{ $post->location }}"
                    class="object-cover object-center w-full h-full aspect-square" />
            </div>
            <div class="lg:w-1/2">
                <div class="flex items-center justify-start w-full border-gray-300  p-2 border-b-[1px]">
                    <x-xs-profile :profile="$post->user" />
                </div>
                <div class="w-full px-2 py-4  border-gray-300 border-b-[1px]">
                    <p class="flex font-bold">
                        <x-heroicon-s-map-pin class="w-6 h-6 text-red-500" />
                        <span>{{ $post->location }}</span>
                    </p>
                    <div class="flex mt-1">
                        <x-heroicon-s-information-circle class="w-6 h-6 text-teal-500" />
                        <p class="whitespace-pre-wrap">{{ $post->description }}</p>
                    </div>
                </div>
                <div class="w-full gap-4 p-2">
                    <div class="flex gap-2">
                        @if ($isLiked)
                            <form method="post" action="{{ route('post.unlike', ['post' => $post]) }}">
                                @csrf <button type="submit" class="flex items-center justify-start">
                                    <x-heroicon-s-heart class="w-6 h-6 text-black cursor-pointer" />
                                    <p class="ml-[2px]">{{ $likes }}</p>
                                </button>
                            </form>
                        @else
                            <form method="post" action="{{ route('post.like', ['post' => $post]) }}">
                                @csrf
                                <button type="submit" class="flex items-center justify-start">
                                    <x-heroicon-o-heart class="w-6 h-6 text-black cursor-pointer" />
                                    <p class="ml-[2px]">{{ $likes }}</p>
                                </button>
                            </form>
                        @endif

                        <div>
                            <x-heroicon-o-chat-bubble-left class="w-6 h-6 text-black cursor-pointer" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-container>
</x-app-layout>
