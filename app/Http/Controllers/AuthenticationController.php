<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthenticationController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function store(Request $request)
    {
        $reqContent = $request->json()->all();
        
        if(!$this->validateRequset($reqContent))
        {
            return json_encode(['error' => 'authentication failed']);
        }        

        $user = User::where('email', $reqContent['email'])->first();

        if($user)
        {
            if ($reqContent['password'] != $user->password)
            {
                return json_encode(['error' => 'authentication failed']);
            }

            $token = $user->createToken('auth_token');
            $resp = [
                'data' => $user->toArray(),
                'token' => $token->plainTextToken
            ];

            return json_encode($resp);
        }
        else
        {
            return json_encode(['error' => 'authentication failed']);
        }
    }

    private function validateRequset($content) : bool
    {
        $desiredData = ['email', 'password'];
        $actualData = array_keys($content);

        if (array_diff($desiredData, $actualData) == []) 
        {
            $validator = Validator::make($content, [
                'email' => 'required|email',
                'password' => 'required|min:4'
            ]);
    
            if ($validator->fails()) {
                return false;
            }

            return true;
        } 
        
        return false;
    }
}
