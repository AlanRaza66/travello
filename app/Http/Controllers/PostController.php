<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $request->user()->likes()->attach($post->id);

        return back()->with('success', 'Tu as aimé cette publication.');
    }
    public function unlike(Post $post, Request $request, )
    {
        $request->user()->likes()->detach($post->id);

        return back()->with('success', 'Tu n\'aimes plus cette publication.');
    }
}
