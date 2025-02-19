<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PostController extends Controller
{
    //
    public function index()
    {
        return view('posts.index');
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $request->validated();

        $fileName = time() . $request->user()->slug . '.' . $request->file('picture')->getClientOriginalExtension();
        $request->file('picture')->move(public_path('uploads/posts/pictures'), $fileName);

        Post::create([
            'location' => $request->input('location'),
            'description' => $request->input('description'),
            'picture' => "uploads/posts/pictures/" . $fileName,
            'user_id' => $request->user()->id,
        ]);

        return Redirect::route('dashboard')->with('success', 'La publication a bien été effectuée');
    }

    public function show(User $user, Post $post): View
    {
        $likes = $post->likes()->count();
        return view('posts.post', ['post' => $post, 'isLiked' => $post->isLiked(), 'likes' => $likes]);
    }

    public function like(Post $post, Request $request, )
    {
        $user = $request->user();
        $liked = $user->likes()->where('post_id', $post->id)->exists();

        if ($liked) {
            $user->likes()->detach($post->id);
            $action = "unlike";
        } else {
            $user->likes()->attach($post->id);
            $action = "like";
        }

        return Response()->json([
            'success' => true,
            'likesTotal' => $post->likes()->count(),
            'action' => $action
        ]);
    }

    public function delete(Post $post)
    {
        if ($post->isMyPost()) {
            $filePath = public_path($post->picture);
            if (file_exists($filePath)) {
                unlink($filePath);
                $post->delete();
                return Redirect::route('profile.index')->with('success', 'La publication a bien été supprimée');
            }
        }

    }

    public function comment(Post $post, Request $request)
    {
        Comment::create([
            "comment" => $request->input("comment"),
            "user_id" => Auth::user()->id,
            "post_id" => $post->id,
            "comment_id" => $request->input("comment_id")
        ]);

        return back()->with('success', 'Tu a commmenté cette publication.');
    }

    public function deleteComment(Comment $comment)
    {
        if ($comment->isMyComment() || $comment->post->isMyPost()) {
            Comment::find($comment->id)->delete();
            return back()->with('success', 'Tu a supprimé ton commentaire.');
        } else {
            return back()->with('error', 'Tu n\'a pas le droit de supprimer ce commentaire.');
        }
    }

    public function likeComment(Comment $comment, Request $request)
    {
        $request->user()->likesComment()->attach($comment->id);

        return back()->with('success', 'Tu as aimé ce commentaire.');
    }

    public function unlikeComment(Comment $comment, Request $request)
    {
        $request->user()->likesComment()->detach($comment->id);

        return back()->with('success', 'Tu n\'aime plus ce commentaire.');
    }
}
