@props(['profile', 'hide' => false])
<a href="{{ route('profile.user', ['user' => $profile->slug]) }}"
    class="flex flex-wrap items-center justify-center gap-2">
    <div class="w-[32px] h-[32px] rounded-[50%] overflow-hidden">
        @if ($profile->picture !== null)
            <img src={{ asset($profile->picture) }} alt="{{ $profile->name }}" width="166" height="166"
                class="object-contain object-center w-full h-full" />
        @else
            <img src={{ asset('/avatar.jpg') }} alt="Photo de profile vide" width="166" height="166"
                class="object-contain object-center w-full h-full" />
        @endif
    </div>
    @if ($hide === false)
        <p class="font-bold">{{ $profile->name }}</p>
    @endif
</a>
