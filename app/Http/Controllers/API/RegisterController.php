<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends BaseController
{
    public function login(Request $request){
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['name'] = $user->name;
            
            return $this->sendResponse($success, 'User login successfully');
        }else{
            return $this->sendError('Unauthorized',[],200);
        }
    }
    public function logout(Request $request){
        $request->user()->token()->revoke();
        return $this->sendResponse([], 'User logged out successfully');        
    }
}
