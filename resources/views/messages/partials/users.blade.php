@props(['users'])
@php
    $me = Auth::user();
@endphp
<div class=" w-[80px] lg:w-[400px]">
    <div class="w-full px-2 py-4 border-gray-300 border-b-[1px] flex items-center justify-between">
        <a href="{{ route('profile.index') }}" class="font-bold">{{ $me->name }}</a>
        <x-heroicon-s-pencil-square class="w-6 h-6 text-black" />
    </div>
    <div class="w-full px-2">
        <h3 class="font-black">Messages</h3>
    </div>
    <div class="w-full">
        @foreach ($users as $user)
            <a href="{{ route('messages.show', ['user' => $user]) }}" class="inline-block w-full p-4">
                <x-xs-profile :profile="$user" :redirect="false" />
            </a>
        @endforeach
    </div>
</div>
