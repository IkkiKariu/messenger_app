<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class TokenController extends Controller
{
    public function show()
    {

    }

    public function create(Request $request)
    {
        $req = $request->all();

        $user = User::where('id', $req['user_id'])->first();
        $token = $user->createToken('auth_token', ['messages:create', 'messages:reply']);
        
        $resp = ['auth_token' => $token->plainTextToken];

        return json_encode($resp);
    }
}
