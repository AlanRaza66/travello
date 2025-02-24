<x-app-layout>
    <div class="flex items-start justify-start">
        <div class="flex flex-col justify-start">
            @include('messages.partials.users', ['users' => $users])
        </div>
    </div>
</x-app-layout>
