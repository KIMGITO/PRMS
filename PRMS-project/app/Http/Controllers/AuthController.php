<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\UserWithOTPCreated;
use App\Services\GenerateOTPService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
class AuthController extends Controller
{
   protected $otp;

   public function __construct(GenerateOTPService $otp){
        $this->otp = $otp;
    }

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

    public function verifyEmailForm()
    {
        $user = auth()->user();
        return view('admin.auth.verify-email',['userName'=>$user->first_name,'email'=>$user->email]);
    }

    public function verifyOTP(Request $request)
    {
        $user = User::where(['id'=>auth()->user()->id])->firstOrFail();
        if($request->input('otp') == $user->verified_at){
            $user = User::where(['id'=>auth()->user()->id])->firstOrFail();
            $user->verified_at = true;
            $user->save();
            return redirect()->intended('/'.$user->role)->with('success',$user->first_name.' Your Email was verified successffuly. Welcome');
        }else{
            return redirect()->back()->with(['error'=>'OTP Missmatched','resend'=>true]);
        }
    }

    public function resendOTP(){
        $user = User::where(['id'=>auth()->user()->id])->firstOrFail();
        $otp = $this->otp->getOTP();
        $user->verified_at = $otp;
        $user->save();
        event(new UserWithOTPCreated($user->email,$otp, 'OTP-verification'));
        return redirect()->route('verify.email.form')->with('success','A new OTP has been sent.');
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
