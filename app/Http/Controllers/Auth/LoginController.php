<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    protected $username;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        // $this->username = $this->findUsername();
    }

    public function username()
    {
        return 'user_email';
        // return 'username';
    }

    public function login(Request $request)
    {
        // dd($request);
        $this->validateLogin($request);

        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        if ($this->attemptLogin($request)) {

            $user = User::where(['user_email' => $request->user_email])->first();
            $ip = $request->ip();
            // activity('login')
            //     ->withProperties(['user_ip' => $ip])
            //     ->log('login');
            // if (Auth::viaRemember()) {
            //     $value = Cookie::get('user_email');
            // }
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        $user = User::where($this->username(), $request->user_email)->first();

        if($user){
            return $this->sendFailedLoginPasswordResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function sendFailedLoginPasswordResponse(Request $request){
        throw ValidationException::withMessages([
            'password' => [trans('auth.password')],
        ]);
    }
    public function logout(Request $request)
    {
        $user = User::where('user_email', $request->user_email)->first();
        $ip = $request->ip();
        // activity('logout')
        //     ->withProperties(['user_ip' => $ip])
        //     ->log('logout');

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $this->loggedOut($request) ?: redirect('/');
    }

    protected function attemptLogin(Request $request)
    {
        $remember_me = false;
        if (isset($request->remember_me)) {
            $remember_me = true;
        }

        return $this->guard()->attempt(
            $this->credentials($request),
            $remember_me
        );
    }

    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        $credentials['is_deleted'] = 0;
        $credentials['user_status'] = 'active';
        $credentials['user_type_id'] = [1, 2, 3]; // login only for admin, news_author

        return $credentials;
    }

    public function field(Request $request)
    {
        $email = $this->username();

        return filter_var($request->get($email), FILTER_VALIDATE_EMAIL) ? $email : 'user_email';
    }

    protected function validateLogin(Request $request)
    {
        $field = $this->field($request);

        $messages = ["{$this->username()}.exists" => 'Invalid Email.'];

        $this->validate($request, [
            $this->username() => "required|exists:tbl_user,{$field}",
            'password' => 'required',
        ], $messages);
    }
}
