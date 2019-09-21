<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

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
        $this->middleware('guest')->except([
            'logout',
            'locked',
            'unlock'
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        //
        $expiresAt = Carbon::now()->addMinutes(15);
        Cache::put('user-is-active-' . $request->user()->id, true, $expiresAt);
    }

    public function locked()
    {
        if(Auth::check()) {
            if(Cache::has('user-is-active-' . Auth::user()->id)) {
                Cache::forget('user-is-active-' . Auth::user()->id);
            }
            return view('auth.lockscreen')->with('message', 'Screen locked');
        } else {
            Session::flush();
        }

        return redirect('/')->with('message', 'Session Expired!!!');
    }

    public function unlock(Request $request)
    {

        if (Auth::check()) {
            $check = Hash::check($request->input('password'), $request->user()->password);

            if(!$check){
                return redirect()->route('login.locked')->withErrors([
                    'Your password does not match your profile.'
                ]);
            }
            $last_session = Session::get('current_page_'.Auth::user()->id);
            $expiresAt = Carbon::now()->addMinutes(5);
            Cache::put('user-is-active-' . Auth::user()->id, true, $expiresAt);
            if($last_session != '' && $last_session != null){

                //Session::forget($current_page);
                return redirect($last_session);
            } else {
                return redirect('/home');
            }
        }

        return redirect('/');
    }
}
