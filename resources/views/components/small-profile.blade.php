@props(['profile'])
<a href="{{ route('profile.user', ['user' => $profile->slug]) }}"
    class="flex flex-wrap items-center justify-center gap-4">
    <div class="w-[55px] h-[55px] lg:h-[86px] lg:w-[86px] rounded-[50%] overflow-hidden">
        @if ($profile->picture !== null)
            <img src={{ asset($profile->picture) }} alt="{{ $profile->name }}" width="166"
                height="166" class="object-contain object-center w-full h-full" />
        @else
            <img src={{ asset('/avatar.jpg') }} alt="Photo de profile vide" width="166"
                height="166" class="object-contain object-center w-full h-full" />
        @endif
    </div>
    <p>{{ $profile->name }}</p>
</a>
