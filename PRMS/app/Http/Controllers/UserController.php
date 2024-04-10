<?php

namespace App\Http\Controllers;

use App\Events\ActivityProcessed;
use App\Models\User;
use App\Events\UserCreated;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Events\UserWithOptCreated;
use App\Events\UserWithOTPCreated;
use App\Events\UserRegisterdWithOTP;
use App\Services\GenerateOTPService;
use Illuminate\Support\Facades\Auth;
use App\Listeners\SendOtpNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $users)
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
       
        $otp = new GenerateOTPService;
        $otp = $otp->getOTP();

       $user = User::create([
            'first_name' => $request->input('firstName'),
            'last_name' => $request->input('lastName'),
            'national_id' => $request->input('nationalId'),
            'work_id' => $request->input('workId'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'role' => $request->input('role'),
            'verified' => $otp,
            'password' => bcrypt($request->input('password')),
        ]);
        if(!auth()->user()){
            $user_id = User::first()->id;
        }else{
            $user_id = auth()->user()->id;
        }
        event(new UserWithOTPCreated($request->input('email'), $otp, 'OTP- Verification'));
        // event(new ActivityProcessed($user_id, 'A new user ('.$user->first_name.' '.$user->last_name.') was created.','create', true));
        if(!auth()->user()){
            return redirect()->route('index');
        }else{
            return redirect()->route('verify.email.form');
        }
    }

    
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
     * Admin update another user
     */
    public function editUser(Request $request, $id){
        try {
            $id = decrypt($id);
            $request['id'] = $id;

            if($this->update($request)){
                return redirect('/admin')->with('success','User was successffuly updated');
            }else{
                return redirect('/admin')->with('error','Failed to update user, please try again');
            }
        } catch (\Throwable $th) {
            abort(400);
        }
    }
   
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
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

        if($user->save()){
            event(new ActivityProcessed(auth()->user()->id, '['.auth()->user()->first_name.'] updated user ( '.$user->first_name.' '.$user->last_name.' ) ','update', true));
        }else{
            event(new ActivityProcessed(auth()->user()->id, '['.auth()->user()->first_name.'] Failed to update user ( '.$user->first_name.' '.$user->last_name.' ) ','update', false));
        }
        return $user->save();
        
    }

    /**
     * Display user profile 
     */

     public function profile(Request $request){
        $user = auth()->user();
        return view('user.profile',['user'=>$user]);
    }

     /**
     * User Profile update
     */

     public function profileUpdate(Request $request){
        $id = auth()->user()->id;
        $role = auth()->user()->role;
        $request['id'] = $id;
        $request['email'] = auth()->user()->email;
        $request['role'] = $role;
        
        $userName = auth()->user()->first_name." ".auth()->user()->last_name;
       
            $user = User::where(['id'=>$id])->firstOrFail();
            $validator = Validator::make($request->all(['password','password_confirmation','phone']),[
                'password' =>'min:8|max:16|nullable|confirmed',
                'phone'=> 'required'
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }else{
                $user->password = bcrypt($request->input('password'));
                $user->phone = $request->input('phone');
                
                if($user->save()){
                    event(new ActivityProcessed(auth()->user()->id, 'User ( '.$userName.' ) updated self','update',true));
                    return redirect('/'.$role)->with('success', ''.$userName.' was successifuly updated ');
                }else{
                    event(new ActivityProcessed(auth()->user()->id, 'User ( '.$userName.' ) failed to updated self','update',false));
                    return redirect('/'.$role)->with('err['.auth()->user()->first_name.']or', 'Faild to update profile');
                }
                
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
            event(new ActivityProcessed(auth()->user()->id, 'User ( '.$userName.' ) tried to delete self while logged in','try',false));
            return redirect('/user/list')->with('error',"ERROR!! As a system administrator, you can't exit from the system this way") ;
        }
        if($user->delete()){
            event(new ActivityProcessed(auth()->user()->id, 'User ( '.$userName.' ) was removed from the system','delete',true));
            return redirect('/user/list')->with('success', 'User '.$userName.' was successifuly removed');
        }else{
            event(new ActivityProcessed(auth()->user()->id, 'Failed to remove user ( '.$userName.' )','delete',false));
            return redirect('/user/list')->with('error',"Error occured when removing '.$id.' from the system") ;
        }
        
    }
}
