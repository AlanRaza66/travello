@php
    $user = Auth::user();
@endphp

<x-app-layout>
    <x-container>
        <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
            <div class="max-w-xl">
                @include('posts.partials.create-post-form')
            </div>
        </div>
    </x-container>
</x-app-layout>
