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
        {{-- TODO transform comment,like and delete comment to AJAX request --}}

        <form method="post" action="{{ route('post.comment.like', ['comment' => $comment]) }}" class="comment-like"
            data-id="{{ $comment->id }}">
            @csrf

            <button type="submit" class="flex items-center justify-start comment-like-button">
                @if ($comment->isLiked())
                    <x-heroicon-s-heart class="w-4 h-4 text-gray-400 cursor-pointer" />
                @else
                    <x-heroicon-o-heart class="w-4 h-4 text-gray-400 cursor-pointer" />
                @endif

                <small class="ml-[2px] text-gray-400"
                    id="{{ 'comment-likes-' . $comment->id }}">{{ $comment->likesTotal() }}</small>

            </button>
        </form>

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

                        <form method="post" action="{{ route('post.comment.like', ['comment' => $answer]) }}"
                            class="comment-like" data-id="{{ $answer->id }}">
                            @csrf
                            <button type="submit" class="flex items-center justify-start comment-like-button">
                                @if ($answer->isLiked())
                                    <x-heroicon-s-heart class="w-4 h-4 text-gray-400 cursor-pointer" />
                                @else
                                    <x-heroicon-o-heart class="w-4 h-4 text-gray-400 cursor-pointer" />
                                @endif
                                <small class="ml-[2px] text-gray-400"
                                    id="{{ 'comment-likes-' . $answer->id }}">{{ $answer->likesTotal() }}</small>
                            </button>
                        </form>

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
    document.addEventListener("click", function(event) {
        if (event.target.closest(".toggle")) {
            const toggleBtn = event.target.closest(".toggle");
            const commentId = toggleBtn.getAttribute("data-id");
            const answerInput = document.getElementById(commentId);

            if (answerInput.classList.contains("hidden")) {
                answerInput.classList.remove("hidden");
                answerInput.classList.add("block");
            } else {
                answerInput.classList.add("hidden");
                answerInput.classList.remove("block");
            }
        }
    });

    //AJAX pour les liker les commentaires
    // TODO: Optimize this
    document.querySelectorAll(".comment-like").forEach(form => {
        form.replaceWith(form.cloneNode(true));
    });

    document.querySelectorAll(".comment-like").forEach((form) => {
        form.addEventListener("submit", function(event) {
            event.preventDefault();

            const url = this.action;
            const method = this.method;
            const data = new FormData(this);
            const id = this.getAttribute("data-id")
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
                        // Mettre à jour le nombre de likes
                        document.getElementById(`comment-likes-${id}`).innerText = data.likesTotal;

                        // Mettre à jour l'icône
                        const likeButton = this.querySelector(".comment-like-button");
                        if (data.action === 'like') {
                            likeButton.innerHTML = `
                        <x-heroicon-s-heart class="w-4 h-4 text-gray-400 cursor-pointer" />
                        <small class="ml-[2px] text-gray-400" id="comment-likes-${id}">${data.likesTotal}</small>
                    `;
                        } else {
                            likeButton.innerHTML = `
                        <x-heroicon-o-heart class="w-4 h-4 text-gray-400 cursor-pointer" />
                        <small class="ml-[2px] text-gray-400" id="comment-likes-${id}">${data.likesTotal}</small>
                    `;
                        }
                    }
                })
                .catch(error => console.error("Erreur :", error))
        })
    })
</script>
