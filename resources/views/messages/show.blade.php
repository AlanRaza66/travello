<x-app-layout>
    <div class="flex items-start justify-start w-full h-screen">
        <div class="h-full border-gray-300 border-r-[1px] ">
            @include('messages.partials.users', ['users' => $users])
        </div>
        <div class="relative w-full h-full">
            <div class="w-full h-[52px] flex items-center justify-start border-gray-300 border-b-[1px] p-2">
                <x-xs-profile :profile="$user" />
            </div>
            <div class="h-[calc(100%-104px)] overflow-y-auto px-10 pb-5" id="messages">
                <div class="w-full flex flex-col items-start justify-end " id="message-container">
                    @foreach ($messages as $message)
                        @if ($user->id === $message->from_id)
                            <div class="flex justify-start w-full mt-2">
                                <div class="flex items-end gap-1 max-w-1/2">
                                    <x-xs-profile :hide="true" :profile="$message->sender" />
                                    <div class="p-2 text-white bg-gray-500 rounded-2xl">
                                        <p class="whitespace-pre-wrap">{{ $message->content }}</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="flex justify-end w-full mt-2">
                                <div class="flex items-end gap-1 max-w-1/2">
                                    <div class="p-2 text-white bg-teal-500 rounded-2xl">
                                        <p class="whitespace-pre-wrap">{{ $message->content }}</p>
                                    </div>
                                    <x-xs-profile :hide="true" :profile="$message->sender" />
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div
                class="h-[52px] w-full p-2 border-gray-300 border-t-[1px] absolute bottom-0 flex items-center justify-center">
                <form id="send-message" method="POST" action="{{ route('messages.send', ['user' => $user]) }}"
                    class="relative w-full h-full">
                    @csrf
                    <textarea type="text" name="content" id="content" placeholder="Ton message..."
                        class="w-full h-full px-2 py-1 overflow-y-auto rounded-3xl"></textarea>
                    <button class="absolute top-0 flex items-center justify-center h-full right-2" type="submit">
                        <x-heroicon-s-paper-airplane class="w-6 h-6 text-sky-500" />
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<script type="module">
    /*
    Show latest messages
    */
    document.addEventListener("DOMContentLoaded", function () {
        let messageContainer = document.getElementById("messages");
        messageContainer.scrollTop = messageContainer.scrollHeight;
    });

    const channel = 'message.' + {{ Auth::user()->id }}
    Echo.channel(channel).listen('messageEvent', (e) => {
        const messageContainer = document.getElementById('message-container');
        const message = document.createElement('div');
        message.classList.add('flex', 'justify-start', 'w-full', 'mt-2');
        message.innerHTML = `<div class="flex items-end gap-1 max-w-1/2">
            <div class="flex flex-wrap items-center justify-start gap-2 cursor-pointer">
        <div class="w-[32px] h-[32px] rounded-[50%] overflow-hidden">
            <img src="${e.to ? e.to : "/avatar.jpg"}" width="166" height="166"
                    class="object-contain object-center w-full h-full" />
            </div></div>
                                <div class="p-2 text-white bg-gray-500 rounded-2xl">
                                    <p class="whitespace-pre-wrap">${e.message}</p>
                                </div>
                            </div>`
        messageContainer.appendChild(message)
    })
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
                    const messageContainer = document.getElementById('message-container');
                    const message = document.createElement('div');
                    message.classList.add('flex', 'justify-start', 'w-full', 'mt-2');
                    message.innerHTML = `<div class="flex justify-end w-full mt-2">
                            <div class="flex items-end gap-1 max-w-1/2">
                                <div class="p-2 text-white bg-teal-500 rounded-2xl">
                                    <p class="whitespace-pre-wrap">${ data.content }</p>
                                </div>
                                <div class="flex flex-wrap items-center justify-start gap-2 cursor-pointer">
        <div class="w-[32px] h-[32px] rounded-[50%] overflow-hidden">
            <img src="${data.from ? data.from : "/avatar.jpg"}" width="166" height="166"
                    class="object-contain object-center w-full h-full" />
            </div></div>
                            </div>`
                    messageContainer.appendChild(message)
                    form.reset()
                } else {
                    console.log(data)
                }
            }).catch(error => console.error("Erreur :", error))
    })
</script>
