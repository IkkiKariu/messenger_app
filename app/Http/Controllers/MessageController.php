<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;


class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::with(['replies' => ['messages.sender'], 'sender'])->where("scope", "global")->get();
        
        $resp = [
            'data' => $messages->toArray(),
            'self' => route('messages.index'),
            'related' => [
                'create_message' => route('messages.create.store')
            ]
        ];
        
        return response()->json($resp);
        // return json_encode($resp); 
    }

    public function store()
    {
        
    }

    public function auth()
    {
        $messages = Message::with(['replies' => ['messages.sender'], 'sender'])->get();
        
        $resp = [
            'data' => $messages->toArray(),
            'self' => route('messages.index'),
            'related' => [
                'create_message' => route('messages.create.store')
            ]
        ];
        
        return response()->json($resp);
        // return json_encode($resp); 
    }
}
