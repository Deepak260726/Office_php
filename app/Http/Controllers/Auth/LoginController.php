<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Spatie\Permission\Traits\HasRoles;

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
    protected $redirectTo = '/dashboard';

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
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
      // Initiate Data Variable
      $data = array();

      return view('auth.login')->with('data', $data);
    }


    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $field = filter_var($request->get($this->username()), FILTER_VALIDATE_EMAIL)
            ? $this->username()
            : 'email';

        return [
            $field => $request->get($this->username()),
            'password' => $request->password,
            'active' => 'Y',
        ];
    }


    /**
     * Set Redirect point based on User role
     *
     * @param  \Illuminate\Http\Request  $request, $user
     * @return void
     */
    protected function authenticated(Request $request, $user)
    {
        $this->redirectTo = '/dashboard';

    
        return redirect($this->redirectTo);

    }
}
