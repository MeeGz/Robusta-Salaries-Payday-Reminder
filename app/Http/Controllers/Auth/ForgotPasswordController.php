<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getResetToken(Request $request)
    {
        $validator =  Validator::make((array)$request->all(), [
            'email'=> 'required|email',
        ],[
            'email.required' => 'enter an email',
            'email.email' => 'enter a valid email',
        ]);
        if ($validator->fails()){
            return response()->json(['error' => $validator->errors()->first()], 400);
        }
        $user = User::where('email', $request->email)->first();
        if (!$user)
            return response()->json(null, 404);
        else{
            $this->broker()->createToken($user);
            $this->broker()->sendResetLink(
                ['email' => $user->email]
            );
            return response()->json(null, 200);
        }
    }
}
