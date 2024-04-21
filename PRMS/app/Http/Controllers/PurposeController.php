<?php

namespace App\Http\Controllers;

use App\Models\Purpose;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Events\ActivityProcessed;

class PurposeController extends Controller
{
    public function index(){
        $purpose = Purpose::all();
        return view('system.config.purpose',['data'=>$purpose]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'purpose' =>'required|string|max:50|unique:purposes,purpose',
            'supervision' => 'required',
            'description' => 'required|max:250'
        ], [
            'description.required' => 'Give a simple explanation of the Request Purpose.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $reason = new Purpose();
        $reason->purpose = $request->input('purpose');
        $reason->supervised = $request->input('supervision');
        $reason->description = $request->input('description');

        if ($reason->save()) {
            // Log the activity of adding a new purpose
            $activityDescription = 'New Purpose added: ' . $request->input('purpose');
            $activityAction = 'add';
            event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, true));

            return redirect()->back()->with('success', 'New Purpose has been added successfully');
        } else {
            // Log the error when adding a new purpose
            $activityDescription = 'Failed to add purpose: ' . $request->input('purpose');
            $activityAction = 'error';
            event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, false));

            return redirect()->back()->with('error', 'Failed to add ' . $request->input('purpose') . ' to purposes.');
        }
    }
        
    public function destroy($id){
        try{
            $id = decrypt($id);
        }catch(\Throwable $e){
            abort(404);
        }
        
        $purpose = Purpose::find($id);

        if($purpose->delete()){
            $activityDescription = 'Deleted a purpose';
            $activityAction = 'delete';
            event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, true));
            return  redirect()->back()->with('success', 'Purpose '. $purpose->purpose.'was deleted.');
        } else{
            $activityDescription = 'Failed to delete purpose';
            $activityAction = 'delete';
            event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, false));
            return  redirect()->back()->with('error', 'Failed to delete purpose '. $purpose->purpose);
        }
    }

    public function edit($id){
        try{
            $id = decrypt($id);
        }catch(\Throwable $e){
            abort(404);
        }
        
        $purpose = Purpose::find($id);
        return view('system.config.purpose-edit',['data'=>$purpose]);
    }


    public function update(Request $request, $id)
    {
        try{
            $id = decrypt($id);
        }catch(\Throwable $e){
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            'purpose' =>'required|string|max:50|unique:purposes,purpose,'.$id,
           'supervision' => 'required',
            'description' => 'required|max:250'
        ], [
            'description.required' => 'Give a simple explanation of the Request Purpose.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $reason = Purpose::find($id);
        $reason->purpose = $request->input('purpose');
        $reason->supervised = $request->input('supervision');
        $reason->description = $request->input('description');
        if($reason->save()){
            $activityDescription = 'Updated a new activity description';
            $activityAction = 'update';
            event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, true));
            return  redirect()->route('config.purpose')->with('success', 'Purpose '. $reason->purpose.' was updated.');
        }
        
    }
    
}
