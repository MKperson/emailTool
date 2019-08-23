<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\User;
use Socialite;
//just installed the socialite from laravel documentation https://laravel.com/docs/5.8/socialite <-- LOOK AT ME!!!

class LoginController extends Controller
{
    use AuthenticatesUsers;
    /**
     * Redirect the user to the Gitlab authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        //so to make gitlab work as i wanted to and not how it was by defalt i modified the vendor files so that it went to the correct subdomain ;)
        //with out modification 'gitlab' would take you to https://gitlab.com/user/sign_in -> getfounds sub domain for gitlab as of 8/7/2019 is http://gitlab.getfoundeugene.com
        //Take note of the missing "S" in the url
            
        return Socialite::driver('gitlab')->redirect();
    }

    /**
     * Obtain the user information from Gitlab.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function handleProviderCallback()
    {
        $user = Socialite::driver('gitlab')->user();
        var_dump($user);

        $users =   User::where(['email' => $user->getEmail()])->first();
        //var_dump($users);
        if ($users) {
            Auth::login($users);
            return redirect('/');
        } else {
            $user = User::create([
                'name'          => $user->getName(),
                'email'         => $user->getEmail(),
                'image'         => $user->getAvatar(),
                'provider_id'   => $user->getId(),
                'provider'      => 'gitlab',
            ]);
            return redirect()->route('home');
        }
        //$user->token;
    }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
//
//this is the old auth login controller 
// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;

// class LoginController extends Controller
// {
//     /*
//     |--------------------------------------------------------------------------
//     | Login Controller
//     |--------------------------------------------------------------------------
//     |
//     | This controller handles authenticating users for the application and
//     | redirecting them to your home screen. The controller uses a trait
//     | to conveniently provide its functionality to your applications.
//     |
//     */

//     use AuthenticatesUsers;

//     /**
//      * Where to redirect users after login.
//      *
//      * @var string
//      */
//     protected $redirectTo = '/';

//     /**
//      * Create a new controller instance.
//      *
//      * @return void
//      */
//     public function __construct()
//     {
//         $this->middleware('guest')->except('logout');
//     }
// }
