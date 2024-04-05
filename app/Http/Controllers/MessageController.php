<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;
use App\Models\Reply;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::with(['replies' => ['message.sender'], 'sender'])->where("scope", "global")->get();
        
        $resp = [
            'data' => $messages->toArray(),
            'self' => route('messages.index'),
            'related' => [
                'create_message' => route('messages.create.store')
            ]
        ];
        
        return response()->json($resp);
    }

    public function store(Request $request)
    {
        $data = $request->json()->all();

        if ($data && array_key_exists("message", $data))
        {
            $user = PersonalAccessToken::where('token', hash('sha256', explode('|', $request->bearerToken())[1]))->first()->user;

            if ($this->validateContent($data["message"], ['content' => 'required', "scope" => "required"]))
            {
                $message = new Message();
                $message->sender_id = $user->id;
                $message->content = $data['message']['content'];
                $message->scope = $data['message']['scope'];

                $message->save();

                return response()->json(["success" => "message sent"]);
            }
            else
            {
                return response()->json(["error" => "message sending failed"]);
            }
        }
        
        return response()->json(["error" => "message sending failed"]);
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
    }

    public function reply(Request $request)
    {
        $data = $request->json()->all();

        if ($data && array_key_exists("message", $data) && array_key_exists("target_message_id", $data))
        {
            if(!Message::where("id", $data["target_message_id"])->first())
            {
                return response()->json(["error" => "message sending failed"]);
            }

            $user = PersonalAccessToken::where('token', hash('sha256', explode('|', $request->bearerToken())[1]))->first()->user;

            if ($this->validateContent($data["message"], ['content' => 'required', "scope" => "required"]))
            {
                $message = new Message();
                $message->sender_id = $user->id;
                $message->content = $data['message']['content'];
                $message->scope = $data['message']['scope'];

                $message->save();

                // return response()->json($message->toArray());

                $reply = new Reply();
                $reply->target_id = $data["target_message_id"];
                $reply->source_id = $message->id;
                $reply->created_at = now();
                $reply->save();

                return response()->json(["success" => "message sent"]);
            }
            else
            {
                return response()->json(["error" => "message sending failed"]);
            }
        }
        
        return response()->json(["error" => "message sending failed"]);
    }

    private function validateContent(array $content, array $required)
    {
        if (array_diff(array_keys($required), array_keys($content)) == []) 
        {
            $validator = Validator::make($content, $required);
    
            if ($validator->fails()) {
                return false;
            }

            return true;
        }

        return false;
    }
}
