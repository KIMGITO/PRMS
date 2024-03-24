<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
class AuthController extends Controller
{
   
    public function login(Request $request)
    {
        $email = $request->input('email');
        $user = User::where('email',$email)->exists();
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $user = auth()->user();
            if($user->role == 'admin'){
                return redirect()->intended('/admin')->with('success','Welcome '.$user->first_name);
            }else{
                return redirect()->intended('/user')->with('success','Welcome '.$user->first_name);
            }
            

        } else {
            // Authentication failed...
            if(empty($user)){
                if(empty($email)){
                    return redirect('/')->with('error', 'Email and password are required');
                }
                return redirect('/')->with('error', 'User with that email does not exist');
            }else{
                return redirect('/')->with('error', 'Account password did not match');
            }
             
            
        }
    }

    public function verifyEmailForm(){
    return view('admin.auth.verify-email');
    }

    public function verifyOTP($id){
    
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
