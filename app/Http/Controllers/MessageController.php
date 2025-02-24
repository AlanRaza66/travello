<?php

namespace App\Http\Controllers;

use App\Models\User;
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
}
