@props(['posts'])
<div class="grid w-full grid-cols-3 gap-[2px] px-1">
    @foreach ($posts as $post)
        <div class="hoverable aspect-[1/1] col-span-1 overflow-hidden top-0 left-0 relative cursor-pointer">
            <div
                class="location absolute top-0 left-0 opacity-0  w-full h-full bg-black bg-opacity-30 duration-[500ms] backdrop-blur-sm flex flex-col items-center justify-center text-white">
                <p class="text-sm">
                    {{ $post->location }}
                </p>
                <x-heroicon-s-map-pin class="w-6 h-6" />
            </div>
            <img src="{{ asset($post->picture) }}" alt="{{ $post->location }}"
                class="object-cover object-center w-full h-full aspect-square" />
        </div>
    @endforeach
</div>
<style>
    .hoverable:hover .location {
        opacity: 1;
    }
</style>
