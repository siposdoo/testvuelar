<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Http\Resources\User as UserResource;

use App\User;

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
    public function logout()
    {
      Auth::logout();
	 
		return redirect('/');
    }
    public function vuelogin(Request $request) 
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
          $user                  = Auth::user();
          $username = $user->name;
          Auth::loginUsingId($user->id);
          return new UserResource($user);
        } else { 
          return response()->json([
            'status' => 'error',
            'user'   => 'Nedozvoljen pristup'
          ]); 
        } 
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
