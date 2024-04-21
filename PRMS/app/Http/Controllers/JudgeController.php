<?php

namespace App\Http\Controllers;

use App\Models\Judge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Events\ActivityProcessed;

class JudgeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $judges = Judge::all();

        return view('system.config.judges',['judges'=>$judges]);
    }



    /**
     * Store a newly created resource in storage.
     */
   

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' =>'required|string|unique:judges,name',
            'gender'=>'required'
        ],[
            'unique'=>'A judge with similar name exists, please try to differentiate them.'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $judge = new Judge();
        $judge->name = $request->input('name');
        $judge->gender = $request->input('gender');

        if($judge->save()){
            $activityDescription = 'New Judge added: ' . $request->input('name');
            $activityAction = 'add';
            event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, true));

            return redirect()->back()->with('success','New Judge, '.$request->input('name').' was added.');
        }else{
            $activityDescription = 'Error when adding judge: ' . $request->input('name');
            $activityAction = 'error';
            event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, false));

            return redirect()->back()->with('error','Error when adding, '.$request->input('name').' to judges.');
        }
    }

    public function edit($id){
        try{
            $id = decrypt($id);
        }catch(\Throwable $e){
            abort(404);
        }
        $judge = Judge::where('id', $id)->firstOrFail();

            return view('system.config.judge-edit',['judge'=>$judge]);
    }

public function update(Request $request, $id){    
    try{
        $id = decrypt($id);
    }catch(\Throwable $e){
        abort(404);
    }

    $validator = Validator::make(request()->all(),[
        'name' =>'required|string|unique:judges,name,'.$id,
        'gender'=>'required'
    ],[
        'unique'=>'A judge with similar name exists, please try to differentiate them.'
    ]);

    if($validator->fails()){
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $judge = Judge::where('id', $id)->firstOrFail();
    $originalName = $judge->name;
    $originalGender = $judge->gender;

    $judge->name = request()->input('name');
    $judge->gender = request()->input('gender');

    if($judge->isDirty()) {
        $activityDescription = 'Updated judge:';
        $activityDetails = [];

        if($originalName !== $judge->name) {
            $activityDetails[] = 'name from ' . $originalName . ' to ' . $judge->name;
        }

        if($originalGender !== $judge->gender) {
            $activityDetails[] = 'gender from ' . $originalGender . ' to ' . $judge->gender;
        }

        $activityDescription .= ' ' . implode(', ', $activityDetails);
        $activityAction = 'update';
        event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, true));
    } else {
        return redirect()->route('config.judge')->with('info', 'No changes were made to the Judge.');
    }

    if($judge->save()){
        return  redirect()->route('config.judge')->with('success', 'Judge '. $judge->name.' was updated.');
    } else {
        return  redirect()->back()->with('error', 'Failed to update judge '. $judge->name);
    }
}

    public function destroy($id){
        try{
            $id = decrypt($id);
        }catch(\Throwable $e){
            abort(404);
        }

        $judge = Judge::find($id);
        if($judge->delete()){
            $activityDescription = 'Deleted a judge';
            $activityAction = 'delete';
            event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, true));
            return  redirect()->route('config.judge')->with('success', 'Judge '. $judge->name.'was deleted.');
        }else{
            $activityDescription = 'Failed to delete judge';
            $activityAction = 'delete';
            event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, false));
            return  redirect()->back()->with('error', 'Failed to delete judge '. $judge->name);
        }
    }
    
}
