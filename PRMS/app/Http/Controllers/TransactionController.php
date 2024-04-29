<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\File;
use App\Models\User;
use App\Models\Purpose;
use App\Models\Department;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Events\ActivityProcessed;

class TransactionController extends Controller
{

    public function loan($id = null){
    try {
        $id = decrypt($id);
    } catch (\Throwable $th) {
        // Log the activity of attempting to access an invalid file ID
        $activityDescription = 'Attempted to access an invalid file ID: ' . $id;
        $activityAction = 'error';
        event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, false));

        abort(404);
    }
        $data = Transaction::where('file_id', $id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!empty($data) && $data->dateBack === null) {
            // Log the activity of attempting to loan an already loaned file
            $activityDescription = 'Attempted to loan an already loaned file: ' . $data->file_id;
            $activityAction = 'error';
            event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, false));

            return redirect()->route('list.files')->with('error', 'This file has been loaned already');
        }

        $file = File::where('id', $id)->firstOrFail();
        $departments = Department::all();
        $purpose = Purpose::all();

        return view('files.loan-file', [
            'file' => $file,
            'purpose' => $purpose,
            'departments' => $departments
        ]);
    
}

    public function storeLoan(Request $request, $id){
    try {
        $id = decrypt($id);
    } catch (\Throwable $th) {
        $activityDescription = 'Attempted to loan an already loaned file with invalid ID ';
        $activityAction = 'error';
        event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, false));

        abort(404);
    }
        $data = Transaction::where('file_id', $id)
            ->orderBy('created_at', 'desc')
            ->first();
        if(!empty($data)){
            if($data->dateBack === null){
                $activityDescription = 'Attempted to loan an already loaned file: ' . $data->file_id;
                $activityAction = 'error';
                event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, false));

                return redirect()->back()->with('error','This file has been loaned already');
            }
        }

        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'caseNumber'=>['required'],
            'department'=>['required'],
            'name'=>['required','string'],
            'dateBack'=>['required','date','after_or_equal:today'],
            'purpose'=>['required']
            
        ],[
            'name.required'=>'Requester name is required.',
            'dateBack.after_or_equal'=>'Date can only be today or future',
            'purpose.required'=>'Check at least one purpose for requesting the file.'
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $purposes = $request->input('purpose');
        $transaction = Transaction::create([
            'file_id'=>$id,
            'user_id'=>$user->id,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'department_id'=>$request->input('department'),
            'name'=>$request->input('name'),
            'issuedDate'=>Carbon::today()->toDateString(),
            'dateExpected'=>$request->input('dateBack')
        ]);
        $transaction->purposes()->attach($purposes);

        // Log the activity of loaning a file
        $activityDescription = 'File loaned: ' . $transaction->file_id;
        $activityAction = 'add';
        event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, true));

        return redirect()->route('list.files')->with('success','File has been loaned.');
    
}

    public function returnFile($id = null){
    $files = Transaction::all()->where('dateBack',null);
        foreach($files as $transaction){
        $transaction['file'] = File::where('id',$transaction->file_id)->first();
        $transaction['user'] = User::select('first_name','last_name')->where('id',$transaction->user_id)->first();
        $now = Carbon::today();
        $expected = $transaction->dateExpected;
        $diffInDays = $now->diffInDays($expected);
        $diffInHours = $now->diffInHours($expected);


    $days = floor($diffInHours / 24);
    $hours = $diffInHours % 24;

    $transaction['period'] = $days . ' days ' . $hours . ' hours';

    if($now->lt($expected)){
        $diffInHours = $diffInHours*-1;
    }

    if($diffInHours > 0){
        $transaction['status'] = 'overdue';
    } else {
        $transaction['status'] = 'pending';
    }
}

    $reasons = [];
    if($id !== null){
        try {
            $id = decrypt($id);
            $specific_transaction = Transaction::find($id);
            $purposes = $specific_transaction->purposes;
        
            foreach($purposes as $purpose){
                $reasons[] = $purpose->purpose;
            }
        } catch (\Throwable $th) {
            $activityDescription = 'Attempted to access an invalid file ID: ' . $id;
            $activityAction = 'error';
            event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, false));

           abort(404);
        }
    }
    return view('files.list-files-on-loan',['transactions'=>$files,'query'=>'','message'=>'','info'=>$id,'purposes' => $reasons]);
}

    public function storeReturn($id){
    try {
        $id = decrypt($id);
        if( Transaction::where(['id'=>$id])->update(['id'=>$id, 'dateBack'=>Carbon::today()])){
            // Log the activity of returning a file
            $activityDescription = 'File returned: ' . $id;
            $activityAction = 'update';
            event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, true));

            return redirect()->back()->with('success','Successfully Restocked The File');
        }else{
            return redirect()->back()->with('error','Failed To Restock');
        }
    } catch (\Throwable $th) {
        // Log the activity of attempting to return a file with wrong input
        $activityDescription = 'Attempted to return a file with wrong input ID: ' . $id;
        $activityAction = 'error';
        event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, false));

        return redirect()->back()->with('error','Wrong Input');
    }
}
   
}
