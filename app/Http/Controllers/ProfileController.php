<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function index(Request $request): View
    {
        $doYouKnow = User::all()->whereNotIn('id', [$request->user()->id])->shuffle()->take(limit: 3);
        return view('profile.index', [
            'user' => $request->user(),
            'doYouKnow' => $doYouKnow
        ]);
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function getUser(User $user, Request $request): View
    {
        $isFollowing = $request->user()->isFollowing($user);
        return view('profile.user', ['user' => $user, 'isFollowed' => $isFollowing]);
    }

    public function follow(User $user, Request $request): RedirectResponse {
        $user->followers()->attach($request->user()->id);
        $message = "Tu suis " . $user->name;
        return Redirect::route('profile.user', ['user' => $user->slug])->with('success', $message);
    }
    public function unfollow(User $user, Request $request): RedirectResponse {
        $user->followers()->detach($request->user()->id);
        $message = "Tu ne suis plus" . $user->name;
        return Redirect::route('profile.user', ['user' => $user->slug])->with('success', $message);
    }
}
