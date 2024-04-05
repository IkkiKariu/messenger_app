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
        $reqContent = $request->json()->all();
        
        if(!$this->validateRequset($reqContent))
        {
            return json_encode(['error' => 'registration failed']);
        }
        
        $user = new User();
        $user->name = $reqContent['name'];
        $user->email = $reqContent['email'];
        $user->password = $reqContent['password'];
        $user->save();
        
        return json_encode(['success' => 'registration completed']);
    }

    private function validateRequset($content) : bool
    {
        $desiredData = ['name', 'password', 'password_confirmation', 'email'];
        $actualData = array_keys($content);

        if (array_diff($desiredData, $actualData) == []) 
        {
            $validator = Validator::make($content, [
                'name' => 'required|min:4|max:25',
                'password' => 'required|min:4',
                'password_confirmation' => 'required',
                'email' => 'required|email'
            ]);
    
            if ($validator->fails()) {
                return false;
            }

            return true;
        } 
        
        return false;
    }
}
