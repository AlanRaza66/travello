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
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users = User::all()->where('id', '!=', Auth::user()->id);
        return view('messages.index', ['users' => $users]);
    }
    /**
     * Summary of show
     * @param \App\Models\User $user
     * @return \Illuminate\Contracts\View\View
     */
    public function show(User $user)
    {
        $me = Auth::user();
        $users = User::all()->where('id', '!=', $me->id);
        $messages = Message::where(function ($query) use ($user, $me) {
            $query->where('from_id', $me->id)->where('to_id', $user->id);
        })->orWhere(function ($query) use ($user, $me) {
            $query->where('to_id', $me->id)->where('from_id', $user->id);
        })->orderBy('created_at', 'asc')->paginate(20);
        return view('messages.show', ['user' => $user, 'users' => $users, 'messages' => $messages]);
    }

    /**
     * Summary of send
     * @param \App\Models\User $user
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
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

        $to = env('APP_URL').'/'.$user->picture;
        $from = env('APP_URL').'/'.$from->picture;
        event(new messageEvent($user->id, $from, $request->content));

        return Response()->json(["success" => true, "content" => $request->content, "message" => "Message envoyé", "from" => $from, "to" => $to], 200);
    }
}
