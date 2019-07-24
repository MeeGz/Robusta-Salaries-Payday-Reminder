<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */
    use ResetsPasswords;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /*******************************************************************************/
    // validation rules for reset password in this broker too as its default is 8 characters hard coded
    // class name Illuminate\Auth\Passwords\PasswordBroker;
    // function name validatePasswordWithDefaults()
    /*******************************************************************************/

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request)
    {
        $this->validate($request, $this->rules());
        $user = User::where('email', $request->email)->first();
        if(!$user)
            return redirect()->back()->withErrors(['emailnotfound'=>'email not found']);
        $token_query = DB::table('password_resets')
            ->where('email','=', $request->email)
            ->where('created_at','>',Carbon::now()->subHours(2));
        $token = $token_query->first();
        if(!$token)
            return redirect()->back()->withErrors(['token'=>'token expired']);
        if(Hash::check($request->token, $token->token))
        {
            $admin = $user->admin;
            if($admin)
            {
                $admin->password = bcrypt($request->password);
                $admin->save();
                $token_query->delete();
                return redirect('/api/forget_success');
            }
            else
                return redirect()->back()->withErrors(['emailnologin' => 'email has no login feature']);
        }
        return redirect()->back()->withErrors(['token' => 'token expired']);
    }

    public function forgetSuccess()
    {
        return view('auth.passwords.success');
    }
}
