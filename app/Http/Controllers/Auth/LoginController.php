<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\SocialProvider;
use Auth;
//use Socialite;
use App\User;
use Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        try
        {
            $socialUser = Socialite::driver($provider)->user();
        }
        catch(\Exception $e)
        {
            return redirect('/');
        }
        //check if we have logged provider
        $socialProvider = SocialProvider::where('provider_id',$socialUser->getId())->first();
        if(!$socialProvider)
        {
            //create a new user and provider
            $user = User::firstOrCreate(
                ['email' => $socialUser->getEmail()],
                ['name' => $socialUser->getName()]
            );
            $user->socialProviders()->create(
                ['provider_id' => $socialUser->getId(), 'provider' => $provider]
            );
        }
        else
            $user = $socialProvider->user;
        auth()->login($user);
        return redirect('/home');
    }

    // public function redirectToProvider($provider)
    // {
    //     return Socialite::driver($provider)->redirect();
    // }

    // public function handleProviderCallback($provider)
    // {
    //     try{
    //         $socialUser = Socialite::driver($provider)->user();
    //     }catch(\Exception $e){
    //         return redirect('/');
    //     }
    //     $socialProvider = SocialProvider::where('provider_id', $socialUser->getId())->first();
    //     if(!$socialProvider){

    //         $user = USer::firstOrCreate(
    //             ['email' => $socialUser->getEmail()],
    //             ['name' => $socialUser->getName()]
    //         );

    //         $user->socialProviders()->create(
    //             ['provider_id' => $socialUser->getId(), 'provider' => $provider]);
    //     }
    //     else
    //         $user = $socialProvider->user;

    //     auth()->login($user);
    //     return redirect('/home');
    //     // $user = Socialite::driver($provider)->user();
    //     // return $user->getEmail();
    //     // $authUser = $this->findOrCreateUser($user, $provider);
    //     // Auth::login($authUser, true);
    //     // return redirect($this->redirectTo);
    // }

    // public function findOrCreateUser($user, $provider)
    // {
    //     $authUser = User::where('provider_id', $user->id)->first();
    //     if ($authUser) {
    //         return $authUser;
    //     }
    //     return User::create([
    //         'name'     => $user->name,
    //         'email'    => $user->email,
    //         'provider' => $provider,
    //         'provider_id' => $user->id
    //     ]);
    // }
}
