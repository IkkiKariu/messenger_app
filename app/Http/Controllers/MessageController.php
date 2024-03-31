<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;


class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::with('replies.messages')->get();
        
        $resp = [
            'data' => $messages->toArray(),
            'self' => route('messages.index'),
            'related' => [
                route('messages.create.store')
            ]
        ];
        

        
        return view('messages.index')->with(['messages' => $messages, 'api_response' => json_encode($resp)]);
    }

    public function store()
    {
        
    }
}
