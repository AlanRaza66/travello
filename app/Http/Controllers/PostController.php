<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

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
}
