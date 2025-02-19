@props(['comment', 'post'])
<div class="flex items-start w-full gap-2 pt-2">
    <x-xs-profile :profile="$comment->user" :hide="true" />
    <div>
        <h2 class="text-sm font-bold">{{ $comment->user->name }}</h2>
        <p class="whitespace-pre-wrap">{{ $comment->comment }}</p>
    </div>
</div>
<div class="flex items-center justify-between w-full">
    <div class="flex gap-3">
        @if ($comment->isLiked())
            <form method="post" action="{{ route('post.comment.unlike', ['comment' => $comment]) }}">
                @csrf
                <button type="submit" class="flex items-center justify-start">
                    <x-heroicon-s-heart class="w-4 h-4 text-gray-400 cursor-pointer" />
                    <small class="ml-[2px] text-gray-400">{{ $comment->likesTotal() }}</small>
                </button>
            </form>
        @else
            <form method="post" action="{{ route('post.comment.like', ['comment' => $comment]) }}">
                @csrf
                <button type="submit" class="flex items-center justify-start">
                    <x-heroicon-o-heart class="w-4 h-4 text-gray-400 cursor-pointer" />
                    <small class="ml-[2px] text-gray-400">{{ $comment->likesTotal() }}</small>
                </button>
            </form>
        @endif

        <div class="flex items-center justify-start cursor-pointer toggle" data-id="{{ $comment->id }}">
            <x-heroicon-o-chat-bubble-left-right class="w-4 h-4 text-gray-400" />
            <small class="ml-[2px] text-gray-400">{{ $comment->countAnswers() }}</small>
        </div>

        @if ($comment->isMyComment() || $post->isMyPost())
            <form method="POST" action="{{ route('post.uncomment', ['comment' => $comment]) }}">
                @csrf
                @method('delete')
                <button type="submit" class="flex items-center justify-start">
                    <x-heroicon-o-trash class="w-4 h-4 text-gray-400 cursor-pointer" />
                </button>
            </form>
        @endif
    </div>
    <small class="text-gray-400">{{ $comment->created_at }}</small>

</div>
<div class="hidden w-full" id="{{ $comment->id }}">
    @if (count($comment->answers) > 0)
        <div class="answers w-full pl-[32px]">
            @foreach ($comment->answers as $answer)
                <div class="flex items-start w-full gap-2 pt-2">
                    <x-xs-profile :profile="$answer->user" :hide="true" />
                    <div>
                        <h2 class="text-sm font-bold">{{ $answer->user->name }}</h2>
                        <p class="whitespace-pre-wrap">{{ $answer->comment }}</p>
                    </div>
                </div>
                <div class="flex items-center justify-between w-full">
                    <div class="flex gap-3">
                        @if ($answer->isLiked())
                            <form method="post" action="{{ route('post.comment.unlike', ['comment' => $answer]) }}">
                                @csrf
                                <button type="submit" class="flex items-center justify-start">
                                    <x-heroicon-s-heart class="w-4 h-4 text-gray-400 cursor-pointer" />
                                    <small class="ml-[2px] text-gray-400">{{ $answer->likesTotal() }}</small>
                                </button>
                            </form>
                        @else
                            <form method="post" action="{{ route('post.comment.like', ['comment' => $answer]) }}">
                                @csrf
                                <button type="submit" class="flex items-center justify-start">
                                    <x-heroicon-o-heart class="w-4 h-4 text-gray-400 cursor-pointer" />
                                    <small class="ml-[2px] text-gray-400">{{ $answer->likesTotal() }}</small>
                                </button>
                            </form>
                        @endif

                        @if ($answer->isMyComment() || $post->isMyPost())
                            <form method="POST" action="{{ route('post.uncomment', ['comment' => $answer]) }}">
                                @csrf
                                @method('delete')
                                <button type="submit" class="flex items-center justify-start">
                                    <x-heroicon-o-trash class="w-4 h-4 text-gray-400 cursor-pointer" />
                                </button>
                            </form>
                        @endif
                    </div>
                    <small class="text-gray-400">{{ $answer->created_at }}</small>

                </div>
            @endforeach
        </div>
    @endif
    <form class="flex w-full" method="post" action="{{ route('post.comment', ['post' => $comment->post]) }}">
        @csrf
        <input class="w-full border-0 answer outline-0 focus:outline-none focus:ring-0" type="text" name="comment"
            placeholder="Ajouter une réponse..." />
        <input class="hidden" name="comment_id" type="number" value="{{ $comment->id }}" />
        <button type="submit"
            class="!rounded-none border-none text-sm font-bold duration-500 hover:text-gray-600">Répondre</button>
    </form>
</div>
<script>
    // Supprimer tous les écouteurs existants
    document.querySelectorAll(".toggle").forEach(toggleBtn => {
        toggleBtn.replaceWith(toggleBtn.cloneNode(true)); // Remplace le bouton par une copie "vierge"
    });

    // Ajouter les écouteurs à nouveau
    document.querySelectorAll(".toggle").forEach(toggleBtn => {
        toggleBtn.addEventListener("click", function() {
            const commentId = this.getAttribute("data-id");
            const answerInput = document.getElementById(commentId);

            if (answerInput.classList.contains("hidden")) {
                answerInput.classList.remove("hidden");
                answerInput.classList.add("block");
            } else {
                answerInput.classList.add("hidden");
                answerInput.classList.remove("block");
            }
        });
    });
</script>
