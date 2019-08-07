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
    /**
     * Redirect the user to the Gitlub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        // $clientId = env('GITLAB_CLIENT_ID');
        // $clientSecret = env('GITLAB_CLIENT_SECRET');
        // $redirectUrl = env('GITLAB_REDIRECT_URI');
        // $additionalProviderConfig = ['site' => 'http://gitlab.getfoundeugene.com/oauth/'];
        // $config = new \SocialiteProviders\Manager\Config($clientId, $clientSecret, $redirectUrl, $additionalProviderConfig);
        // return Socialite::with('gitlab')->setConfig($config)->redirect();


        //return Socialite::with('gitlab')
        //->with(['redirect_uri' => "http://localhost:8000/login/handleProviderCallback"])
        //->redirect();

        //so to make gitlab work as i wanted to and not how it was by defalt i modified the vendor files so that it went to the correct subdomain ;)
        return Socialite::driver('gitlab')->redirect();
    }

    /**
     * Obtain the user information from Gitlub.
     *
     * @return \Illuminate\Http\Response
     */
    use AuthenticatesUsers;
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
//}
//this is the old auth 
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
