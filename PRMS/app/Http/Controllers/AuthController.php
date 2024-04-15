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
use App\Events\ActivityProcessed;
use App\Models\Casetype;
use App\Services\GenerateColors;

class AuthController extends Controller
{
   protected $otp;
   protected $colors;

   public function __construct(GenerateOTPService $otp, GenerateColors $colors){
        $this->otp = $otp;
        $this->colors = $colors;
    }


    public function login(Request $request)
{
    $email = $request->input('email');
    $user = User::where('email', $email)->exists();
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        // Authentication passed...

        $user = $request->user();
        if ($user->role == 'admin') {
            return redirect()->intended('/admin');
        } else {
            return redirect()->intended('/user');
        }

    } else {
        // Authentication failed...
        if (empty($user)) {
            if (empty($email)) {
                return redirect('/')->with('error', 'Email and password are required');
            }
            return redirect('/')->with('error', 'User with that email does not exist');
        } else {
            return redirect('/')->with('error', 'Account password did not match');
        }

    }
}

    public function adminDash(){
        $names = Casetype::all();
        $colors = $this->colors->getVisualization($names);
        $data = [];
        foreach($names as $name){
            $data[] = $name->initials;
        }
        return view('admin.home', ['type'=>$data,'colors'=>$colors,'name'=>'Case Types'])->with('success','Welcome '.auth()->user()->first_name);
    }

    function userDash() {
        $types = Casetype::all();
        return view('user.home', ['type'=>$types])->with('success','Welcome '.auth()->user()->first_name);
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
            event(new ActivityProcessed(auth()->user()->id, 'Email for user ( '.$user->first_name.' '.$user->last_name.' ) verified','verifie', true));
            return redirect()->intended('/'.$user->role)->with('success',$user->first_name.' Your Email was verified successffuly. Welcome');

        }else{
            event(new ActivityProcessed(auth()->user()->id, 'Failed to verifiy email for ( '.$user->first_name.' '.$user->last_name.' )','verify', false));
            return redirect()->back()->with(['error'=>'OTP Missmatched','resend'=>true]);

        }
    }

    public function resendOTP(){
        $user = User::where(['id'=>auth()->user()->id])->firstOrFail();
        $otp = $this->otp->getOTP();
        $user->verified = $otp;
        $user->save();
        event(new UserWithOTPCreated($user->email,$otp, 'OTP-verification'));
        event(new ActivityProcessed(auth()->user()->id, 'OTP verification sent for ( '.$user->first_name.' '.$user->last_name.' ) ','otp-sent', true));
        return redirect()->route('verify.email.form')->with('success','A new OTP has been sent.');
    }

    public function logout(){
        event(new ActivityProcessed(auth()->user()->id, 'User ( '.auth()->user()->first_name.' '.auth()->user()->last_name.' ) logged out','logout', true));
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
                    if(PasswordResetToken::insert(['email'=>$email,'token'=>$token])){
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
            event(new ActivityProcessed(auth()->user()->id, 'User ( '.$user->first_name.' '.$user->last_name.' ) updated password','update', true));
            return redirect('/')->with('success','Password successffully updated');
        }else{
            event(new ActivityProcessed(auth()->user()->id, 'Failed to update password for ( '.$user->first_name.' '.$user->last_name.' ) ','update', false));
            return redirect()->back()->with('error','Failed to update password. Try again');
        }

    }
}
