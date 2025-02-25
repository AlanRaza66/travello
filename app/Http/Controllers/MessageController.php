<?php

namespace App\Http\Controllers;

use App\Events\messageEvent;
use App\Events\testingEvent;
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
        $me = Auth::user();
        $users = User::all()->where('id', '!=', $me->id);
        $messages = Message::where(function ($query) use ($user, $me) {
            $query->where('from_id', $me->id)->where('to_id', $user->id);
        })->orWhere(function ($query) use ($user, $me) {
            $query->where('to_id', $me->id)->where('from_id', $user->id);
        })->orderBy('created_at', 'asc')->get();
        return view('messages.show', ['user' => $user, 'users' => $users, 'messages' => $messages]);
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

        event(new messageEvent($user->id, $request->content));

        return Response()->json(["success" => true, "content" => $request->content, "message" => "Message envoyé"], 200);
    }
}
