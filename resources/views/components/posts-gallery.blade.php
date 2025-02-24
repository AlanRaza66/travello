@props(['posts'])
<div class="grid w-full grid-cols-3 gap-[2px] px-1">
    @foreach ($posts as $post)
        <a href="{{ route('post.show', ['user' => $post->user, 'post' => $post]) }}"
            class="hoverable aspect-[1/1] col-span-1 overflow-hidden top-0 left-0 relative cursor-pointer">
            <div
                class="location absolute top-0 left-0 opacity-0  w-full h-full bg-black bg-opacity-30 duration-[500ms] backdrop-blur-sm flex flex-col items-center justify-center text-white">
                <div class="flex-col items-center justify-center hidden lg:flex">
                    <p class="text-sm">
                        {{ $post->location }}
                    </p>
                    <x-heroicon-s-map-pin class="w-6 h-6" />
                </div>
                <div class="absolute flex items-center justify-start gap-4 text-white bottom-4 left-4">
                    <div class="flex items-center justify-start">
                        @if ($post->isLiked())
                            <x-heroicon-s-heart class="w-3 h-3 cursor-pointer lg:w-6 lg:h-6" />
                            <p class="ml-[2px]">{{ $post->likesTotal() }}</p>
                        @else
                            <x-heroicon-o-heart class="w-3 h-3 cursor-pointer lg:w-6 lg:h-6" />
                            <p class="ml-[2px]">{{ $post->likesTotal() }}</p>
                        @endif
                    </div>
                    <div class="flex items-center justify-start">
                        <x-heroicon-o-chat-bubble-left class="w-3 h-3 cursor-pointer lg:w-6 lg:h-6" />
                        <p class="ml-[2px]">{{ count($post->comments) }}</p>
                    </div>
                </div>
            </div>
            <img src="{{ asset($post->picture) }}" alt="{{ $post->location }}"
                class="object-cover object-center w-full h-full aspect-square" />
        </a>
    @endforeach
</div>
<style>
    .hoverable:hover .location {
        opacity: 1;
    }
</style>
