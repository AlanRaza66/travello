<x-app-layout>
    <div class="flex items-start justify-start">
        <div class="flex flex-col justify-start w-64">
            @foreach ($users as $user)
                <div class="w-full p-4">
                    <x-xs-profile :profile="$user" :redirect="false" />
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
