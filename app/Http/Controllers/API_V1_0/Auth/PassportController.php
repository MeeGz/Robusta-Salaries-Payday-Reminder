<?php

namespace App\Http\Controllers\API_V1_0\Auth;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PassportController extends Controller
{
    public function login(Request $request){
        $data = $request->all();
        $validator =  Validator::make((array)$data, [
            'email'=> 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()){
            return response()->json(['error' => $validator->errors()->first()], 400);
        }
        $attempt = Auth::attempt(['email' => $data['email'], 'password' => $data['password']]);
        if ($attempt){
            $user = Auth::user();
            $user_to_return = (object)[];
            $user_to_return->id = $user->id;
            $user_to_return->name = $user->name;
            $user_to_return->email = $user->email;
            $user_to_return->token = $user->createToken('MyApp')->accessToken;
            return response()->json($user_to_return, 200);
        }
        else{
            $user = User::where('email', $data['email'])->exists();
            if($user)
                return response()->json(null, 401);
            return response()->json(null, 404);
        }
    }

    public function logout()
    {
        $accessToken = Auth::user()->token();
        if(!$accessToken)
            return response()->json(null, 400);
        $accessToken->delete();
        return response()->json(null, 200);
    }

}
