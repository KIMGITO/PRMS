<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\UserWithOTPCreated;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\URL;
use App\Events\ResetPasswordRequest;
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
        return view('admin.auth.verify-email',['message'=>'An email with 6 Digits OTP was sent to '.$user->email]);
    }

    public function verifyOTP(Request $request)
    {
        $user = User::where(['id'=>auth()->user()->id])->firstOrFail();
        if($request->input('otp') == $user->verified){
            $user = User::where(['id'=>auth()->user()->id])->firstOrFail();
            $user->verified = true;
            $user->save();
            return redirect()->intended('/'.$user->role)->with('success',$user->first_name.' Your Email was verified successffuly. Welcome');
        }else{
            return redirect()->back()->with(['error'=>'OTP Missmatched','resend'=>true]);
        }
    }

    public function resendOTP(){
        $user = User::where(['id'=>auth()->user()->id])->firstOrFail();
        $otp = $this->otp->getOTP();
        $user->verified = $otp;
        $user->save();
        event(new UserWithOTPCreated($user->email,$otp, 'OTP-verification'));
        return redirect()->route('verify.email.form')->with('success','A new OTP has been sent.');
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }

    public function forgotPassword(){
        return view('user.auth.forgot-password');
    }

    public function forgotPasswordEmail(Request $request){
        $validator = Validator::make($request->all(),[
            'email'=>'required|email'
        ]);
        
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $email = $request->input('email');
            $user = User::where('email',$email)->first();
            if($user){
                $subject = 'Reset Email';
                $token = Str::random(60);
                $link = URL::signedRoute('reset.password.form',['token'=>$token]);

                $response = event(new ResetPasswordRequest($subject, $link, $email));

                if(!empty($response[0])){
                    return redirect()->back()->with('error',$response[0])->withInput();
                }else{
                    $availableToken = PasswordResetToken::where(['email'=>$email])->first();
                    if($availableToken){
                        $availableToken->where(['email'=>$email])->delete();
                    }
                    if(PasswordResetToken::insert(['email'=>$email,'token'=>$token,'created_at'=>Carbon::now()])){
                        return redirect()->route('reset.password.email.sent');
                    }
                }
                
            }else{
                return redirect()->back()->with('error','Account with that email was not found. Contact admin for more information ');
            }
        }
    }

    public function resetPasswordForm(Request $request, $token){
        $email = PasswordResetToken::where('token',$token)->value('email');
        if(!$email){
            return redirect()->route('forgot.password.form')->with('error','The link you are trying to access has expired. Re enter the email to recive another link');
        }
        return view('user.auth.reset-password',['token'=>$token]);
    }
    public function resetPassword(Request $request, $token){
        $email = PasswordResetToken::where('token',$token)->value('email');
        $validator = Validator::make($request->only(['password','password_confirmation']),[
            'password'=>'required|min:8|max:16|confirmed'
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }
        $user = User::where(['email'=>$email])->firstOrFail();
        $user->password = bcrypt($request->input('password'));

        if($user->save()){
            PasswordResetToken::where(['email'=>$email])->delete();
            if(auth()->user() && auth()->user()->email == $email){
                Auth::logout();
            }
            return redirect('/')->with('success','Password successffully updated');
        }else{
            return redirect()->back()->with('error','Failed to update password. Try again');
        }

    }
}
