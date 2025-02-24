<x-app-layout>
    <div class="flex items-start justify-start w-full lg:h-screen">
        <div class="w-64 h-full border-gray-300 border-r-[1px]">
            @include('messages.partials.users', ['users' => $users])
        </div>
        <div class="w-full h-full">
            <div class="w-full p-2 flex items-start border-gray-300 border-b-[1px]">
                <x-xs-profile :profile="$user" />
            </div>
        </div>
    </div>
</x-app-layout>
