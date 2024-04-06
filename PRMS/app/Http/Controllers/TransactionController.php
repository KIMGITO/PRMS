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

class TransactionController extends Controller
{

    public function loan($id = null){
       
        try {
         $id = decrypt($id);
        }
        catch (\Throwable $th) {
            abort(404);
            return redirect()->back();
        }

         $data = Transaction::where('file_id',$id)
                ->orderBy('created_at','desc')
                ->first();
        if(!empty($data)){
            if($data->dateBack === null){
                return redirect()->route('list.files')->with('error','This file has been loaned already');
            }
        }
         

         $file = File::where('id',$id)->firstOrFail();
         $departments = Department::all();
         $purpose = Purpose::all();
         return view('files.loan-file',[
            'file'=>$file,
            'purpose'=>$purpose,
            'departments'=>$departments
        ]);
        
         
     }

    public function storeLoan(Request $request, $id){
        // dd($request->all());
        try {
            $id = decrypt($id);
           
            $data = Transaction::where('file_id', $id)
            ->orderBy('created_at', 'desc')
            ->first();
            if(!empty($data)){
                if($data->dateBack === null){
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
            Transaction::create([
                'file_id'=>$id,
                'user_id'=>$user->id,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
                'department_id'=>$request->input('department'),
                'name'=>$request->input('name'),
                'issuedDate'=>Carbon::today()->toDateString(),
                'dateExpected'=>$request->input('dateBack')
            ])->purposes()->attach($purposes);
           
            return redirect()->route('list.files',)->with('success','File has been loaned.');
        } catch (\Throwable $th) {
            abort(404);
        }
        

    }

    public function returnFile($id = null){
        $files = Transaction::all()->where('dateBack',null);
        
        foreach($files as $transaction){
            $transaction['file'] = File::where('id',$transaction->file_id)->first();
            $transaction['user'] = User::select('first_name','last_name')->where('id',$transaction->user_id)->first();
           
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
               abort(404);
            }
        }
            return view('files.list-files-on-loan',['transactions'=>$files,'query'=>'','message'=>'','info'=>$id,'purposes' => $reasons]);
    }

    public function storeReturn($id){
        try {
            $id = decrypt($id);
            if( Transaction::where(['id'=>$id])->update(['id'=>$id, 'dateBack'=>Carbon::today()])){
                return redirect()->back()->with('success','Successffuly Re-stocked The File');
            }else{
                return redirect()->back()->with('error','Failed To Re-stock');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','Wrong Input');
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
