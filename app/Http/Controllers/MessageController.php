<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    //
    public function index()
    {
        $users = User::all()->where('id', '!=', Auth::user()->id);
        return view('messages.index', ['users' => $users]);
    }

    public function show(User $user)
    {
        $users = User::all()->where('id', '!=', Auth::user()->id);
        return view('messages.show', ['user' => $user, 'users' => $users]);
    }

    public function send(User $user, Request $request)
    {
        $from = Auth::user();
        $isValid = $request->validate([
            "content" => "string|required",
        ]);
        $userExists = User::find($user);
        if (!$userExists) {
            return Response()->json(["success" => false, 'message' => 'Le destinataire n\'est pas disponible'], 400);
        }

        if (!$isValid) {
            return Response()->json(["success" => false, 'message' => 'Le message n\'a pas pu être envoyé'], 400);
        }

        Message::create([
            "from_id" => $from->id,
            "to_id" => $user->id,
            "content" => $request->content,
        ]);

        return Response()->json(["success" => true, "content" => $request->content, "message" => "Message envoyé"], 200);
    }
}
