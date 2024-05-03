<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Events\ActivityProcessed;

class ClientController extends Controller
{
    public function index(){
        return view('client.register');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|regex:/^[\pL\s\-]+ [\pL\s\-]+$/u',
            'email' => 'required|email|unique:clients,email',
        ],[
            'name.regex' => 'Enter full name'
        ]);

        $nameParts = explode(' ', $request->name); // Split the name into parts
        $firstName = $nameParts[0]; // Get the first part of the name
        $lastName = isset($nameParts[1]) ? $nameParts[1] : ''; // Get the second part of the name if it exists

        $userName = strtolower($firstName . substr($lastName, 0, 1)); // Generate username from the name parts

        // Check for uniqueness and append a number if the username already exists
        $baseUserName = $userName;
        while (Client::where('user_name', $userName)->exists()) {
            $userName = $baseUserName . random_int(01, 999);
        }

        $client = new Client();
        $client->name = $request->name;
        $client->email = $request->email;
        $client->user_name = $userName; 
        $client->save();

        event(new ActivityProcessed(auth()->user()->id, 'Client was created', 'create', true));
        return redirect()->route('new.client')->with('success', 'Successfully registered. Your Username is '.$userName);
    }
}
