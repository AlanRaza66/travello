<x-app-layout>
    <x-container class="h-screen bg-red-500">
        <div class="flex flex-wrap items-start justify-start w-full overflow-hidden bg-white sm:rounded-lg">
            <div class="relative lg:w-1/2 aspect-square">
                <img src="{{ asset($post->picture) }}" alt="{{ $post->location }}"
                    class="object-cover object-center w-full h-full aspect-square" />
                @if ($post->isMyPost())
                    <form method="post" action="{{ route('post.delete', ['post' => $post]) }}"
                        class="absolute top-4 right-4">
                        @csrf
                        @method('delete')
                        <button>
                            <x-heroicon-o-trash class="w-6 h-6 text-white" />
                        </button>
                    </form>
                @endif
            </div>
            <div class="w-full overflow-auto lg:w-1/2 lg:aspect-square relative aspect-[unset] bg-white">
                <div class="sticky top-0 left-0 w-full bg-white">
                    <div class="flex items-center justify-start w-full border-gray-300  p-2 border-b-[1px]">
                        <x-xs-profile :profile="$post->user" />
                    </div>
                    <div class="w-full px-2 py-4  border-gray-300 border-b-[1px] bg-white">
                        <p class="flex font-bold">
                            <x-heroicon-s-map-pin class="w-6 h-6 text-red-500" />
                            <span>{{ $post->location }}</span>
                        </p>
                        <div class="flex mt-1 bg-white">
                            <x-heroicon-s-information-circle class="w-6 h-6 text-teal-500" />
                            <p class="whitespace-pre-wrap">{{ $post->description }}</p>
                        </div>
                    </div>
                    <div class="w-full gap-4 p-2  border-gray-300 border-b-[1px] bg-white">
                        <div class="flex gap-2">
                            @if ($isLiked)
                                <form method="post" action="{{ route('post.unlike', ['post' => $post]) }}">
                                    @csrf <button type="submit" class="flex items-center justify-start">
                                        <x-heroicon-s-heart class="w-6 h-6 text-black cursor-pointer" />
                                        <p class="ml-[2px]">{{ $likes }}</p>
                                    </button>
                                </form>
                            @else
                                <form method="post" action="{{ route('post.like', ['post' => $post]) }}">
                                    @csrf
                                    <button type="submit" class="flex items-center justify-start">
                                        <x-heroicon-o-heart class="w-6 h-6 text-black cursor-pointer" />
                                        <p class="ml-[2px]">{{ $likes }}</p>
                                    </button>
                                </form>
                            @endif

                            <div class="flex items-center justify-start">
                                <x-heroicon-o-chat-bubble-left class="w-6 h-6 text-black cursor-pointer" />
                                <p class="ml-[2px]">{{ count($post->comments) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if (count($post->comments) > 0)
                    <div class="w-full px-2  border-gray-300 border-b-[1px] overflow-auto">
                        @foreach ($post->commentsWithoutAnswers as $comment)
                            <x-comment :comment="$comment" :post="$post" />
                        @endforeach
                    </div>
                @endif
                <div class="sticky border-gray-300 border-t-[1px] bottom-0 w-full">
                    <form method="post" class="flex w-full" action="{{ route('post.comment', ['post' => $post]) }}">
                        @csrf
                        <input class="w-full border-0 outline-0 focus:outline-none focus:ring-0" type="text"
                            id="comment" name="comment" placeholder="Ajouter un commentaire..." /><x-primary-button
                            class="!rounded-none">Publier</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </x-container>
</x-app-layout>
