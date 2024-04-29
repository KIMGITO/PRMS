<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Message;

class MessageController extends Controller
{
    public function index(){
        return view('client.message');
    }

    public function store(Request $request){
    $request->validate([
        'username' => 'required',
        'message' => 'required'
    ]);

    $client = Client::where('user_name', $request->username)
                    ->orWhere('email', $request->username)
                    ->first();

    if ($client) {
        $message = new Message();
        $message->body = $request->message;
        $message->client_id = $client->id;
        $message->save();
        return redirect()->route('index')->with('success', 'Message sent successfully');
    } else {
        return redirect()->back()->with('error', 'Username or email not found');
    }
}
}
