<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class RegistrationController extends Controller
{
    
    public function index()
    {
        return view('register.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4|max:25',
            'password' => 'required|min:4',
            'password_confirmation' => 'required|same:password',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return redirect(route('register.index'));
        }

        $validated = $validator->validated();

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = $validated['password'];
        $user->save();
        
        // return $validator->validated();
    }
}
