<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    // Google Login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        $GoogleUser = Socialite::driver('google')->user();

        $this->_registerOrLoginUser($GoogleUser);

        return redirect()->route('dashboard');

    }

    // Facebook Login
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function handleFacebookCallback()
    {
        $facebookUser = Socialite::driver('facebook')->user();

        $this->_registerOrLoginUser($facebookUser);

        return redirect()->route('dashboard');

    }

    // Github Login
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }
    public function handleGithubCallback()
    {
        $githhubUser = Socialite::driver('github')->user();

        $this->_registerOrLoginUser($githhubUser);

        return redirect()->route('dashboard');
    }

    public function _registerOrLoginUser($data)
    {
        $user = User::where('email', $data->email)->first();
        if(!$user)
        {
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->avatar = $data->avatar;
            $user->save();
        }
        Auth::login($user);
    }
}
