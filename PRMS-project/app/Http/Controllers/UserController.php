<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Events\UserCreated;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Events\UserWithOptCreated;
use App\Events\UserWithOTPCreated;
use App\Events\UserRegisterdWithOTP;
use App\Listeners\SendOtpNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);
        return view ('admin.users.list-users',['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.new-user');
    }

    public function createAdmin(){
        return view('admin.first-admin');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //create new user
        $customAttributes=[
            'firstName'=>'Fist Name',
            'lastName'=>'Last Name',
            'nationalId'=>'ID Number',
            'workId'=>'Job Number',
            'email'=>'Email Address',
            'phone'=>'Phone Number'
        ];
        
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'nationalId' => 'required|numeric|digits:8|unique:users,national_id',
            'workId' => 'required|string|max:15|unique:users,work_id',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8',
        ]);
        $validator->setAttributeNames($customAttributes);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
       
        $otp = $this->makeOTP();
        $user = User::create([
            'first_name' => $request->input('firstName'),
            'last_name' => $request->input('lastName'),
            'national_id' => $request->input('nationalId'),
            'work_id' => $request->input('workId'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'role' => $request->input('role'),
            'verified_at' => $otp,
            'password' => bcrypt($request->input('password')),
        ]);

        event(new UserWithOTPCreated($request->input('email'), $otp, 'OTP- Verification'));



        // $userName = $request->input('firstName')." ".$request->input('lastName');
        // if($user->save())
        // {
            
        //     return redirect('/admin')->with('success', 'New User, '.$userName.' was successifuly created');
        // }else{
        //     return redirect('/admin')->with('error',"Error occured when creating user '.$userName.'") ;
        // }
        

        
    }

    private function makeOTP(){
        $otp = mt_rand(123456, 987654);
        return $otp;
    }
    /**
     * Create an admin user when system launhes
     */

     public function storeAdmin(Request $request)
    {
        //create new user
        $customAttributes=[
            'firstName'=>'Fist Name',
            'lastName'=>'Last Name',
            'nationalId'=>'ID Number',
            'workId'=>'Job Number',
            'email'=>'Email Address',
            'phone'=>'Phone Number'
        ];
        
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'nationalId' => 'required|numeric|digits:8|unique:users,national_id',
            'workId' => 'required|string|max:15|unique:users,work_id',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8',
        ]);

        $validator->setAttributeNames($customAttributes);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $otp = $this->makeOTP();
        $user = User::create([
            'first_name' => $request->input('firstName'),
            'last_name' => $request->input('lastName'),
            'national_id' => $request->input('nationalId'),
            'work_id' => $request->input('workId'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'role' => $request->input('role'),
            'verified_at' => $otp,
            'password' => bcrypt($request->input('password')),
        ]);

        event(new UserWithOTPCreated($request->input('email'),$otp, 'OTP-verification'));        
        return redirect()->route('verify.email.form');
       
    }

    /**
     * Display the specified resource.
     */
    public function show(user $user)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(user $user, $id)
    {
        $user = User::where('id',$id)->firstOrFail();
        return view('admin.users.edit-user',['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, user $user)
    {
        //edit user
        $customAttributes=[
            'fistName'=>'Fist Name',
            'lastName'=>'Last Name',
            'nationalId'=>'ID Number',
            'workId'=>'Job Number',
            'email'=>'Email Address',
            'phone'=>'Phone Number'
        ];
        $user = User::findOrFail($request->input('id'));
        
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'nationalId' => 'required|numeric|digits:8',
            'workId' => 'required|string|max:15',
            'phone' => 'required|string|max:15',
            'id'=>'required',
        ]);
        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        $validator->setAttributeNames($customAttributes);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        

        $user->first_name = $request->input('firstName');
        $user->last_name = $request->input('lastName');
        $user->national_id = $request->input('nationalId');
        $user->work_id = $request->input('workId');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->role = $request->input('role');

        $userName = $user->first_name." ".$user->last_name;

        if($user->save())
        {
            return redirect('/admin')->with('success', ''.$userName.' was successifuly updated ');
        }else{
            return redirect('/admin')->with('error',"Error occured when Updating '.$userName.'") ;
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user $user, $id)
    {
        $user = User::where('id',$id)->firstOrFail();
        $userName = $user['first_name']." ".$user['last_name'];
        if(auth()->user()->id == $id){
            return redirect('/listUser')->with('error',"ERROR!! As a system administrator, you can't exit from the system this way") ;
        }
        if($user->delete()){
            return redirect('/listUser')->with('success', 'User '.$userName.' was successifuly removed');
        }else{
            return redirect('/listUser')->with('error',"Error occured when removing '.$id.' from the system") ;
        }
    }
}
