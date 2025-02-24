<x-app-layout>
    <div class="flex items-start justify-start w-full lg:h-screen">
        <div class="h-full border-gray-300 border-r-[1px] ">
            @include('messages.partials.users', ['users' => $users])
        </div>
        <div class="relative w-full h-full">
            <div class="w-full h-[52px] flex items-center justify-start border-gray-300 border-b-[1px] p-2">
                <x-xs-profile :profile="$user" />
            </div>
            <div class="w-full h-[calc(100%-104px)] flex items-end justify-between overflow-x-auto px-10 pb-5">
                <p>Test</p>
                <p>Test</p>
            </div>
            <div
                class="h-[52px] w-full p-2 border-gray-300 border-t-[1px] absolute bottom-0 flex items-center justify-center">
                <form id="send-message" method="POST" action="{{ route('messages.send', ['user' => $user]) }}"
                    class="relative w-full h-full">
                    @csrf
                    <input type="text" name="content" id="content" placeholder="Ton message..."
                        class="w-full h-full rounded-3xl" />
                    <button class="absolute top-0 flex items-center justify-center h-full right-2" type="submit">
                        <x-heroicon-s-paper-airplane class="w-6 h-6 text-sky-500" />
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    const form = document.getElementById('send-message');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const url = this.action;
        const method = this.method;
        const data = new FormData(this);

        fetch(url, {
                method: method,
                body: data,
                headers: {
                    'X-CSRF-TOKEN': data.get('_token')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log(data)
                } else {
                    console.log(data)
                }
            }).catch(error => console.error("Erreur :", error))
    })
</script>
