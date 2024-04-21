<?php

namespace App\Http\Controllers;

use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Events\ActivityProcessed;

class CourtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $courts = Court::all();
        return view('system.config.courts',['courts'=>$courts]);
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
    $validator = Validator::make($request->all(),[
        'name'=>'required|string|unique:courts,name'
    ],[
        'name.required' => 'Court name is required.',
        'unique'=>'Court name already exists.'
    ]);

    if($validator->fails()){
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $court = new Court();
    $court->name = $request->input('name');

    $activityDescription = 'Created a new court: ' . $court->name;
    $activityAction = 'create';
    $activityStatus = $court->save();

    if($activityStatus){
        event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, true));
        return redirect()->back()->with('success','New Court, '.$request->input('name').' Was added.');
    }else{
        event(new ActivityProcessed(auth()->user()->id, 'Failed to create a new court', 'create', false));
        return redirect()->back()->with('error','Error when adding , '.$request->input('name'))->withInput();
    }
    }  

    public function edit ($id){
        try{
            $id = decrypt($id);
        }catch(\Throwable $e){
            abort (404);
        }

        $court = Court::find($id);
        return view('system.config/courts-edit', ['data'=>$court]);
    }

    public function update(Request $request, $id){
    try{
        $id = decrypt($id);
    }catch(\Throwable $e){
        abort (404);
    }

    $court = Court::find($id);
    $originalName = $court->name; // Get the original name before updating

    if ($originalName !== $request->input('name')) {
        $court->name = $request->input('name');
        $activityDescription = 'Updated court: ' . $originalName . ' to ' . $request->input('name');
        $activityAction = 'update';
        $activityStatus = $court->save();

        if ($activityStatus) {
            event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, true));
            return redirect()->route('config.court')->with('success', 'Court ' . $originalName . ' was updated to ' . $request->input('name'));
        } else {
            event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, false));
            return redirect()->back()->with('error', 'Failed to update court ' . $originalName);
        }
    } else {
        return redirect()->route('config.court')->with('info', 'No changes were made to the Court.');
    }
}

    public function destroy($id){
        try{
            $id = decrypt($id);
        }catch(\Throwable $e){
            abort (404);
        }
        $court = Court::find($id);
        if($court->delete()){
            $activityDescription = 'Deleted a court';
            $activityAction = 'delete';
            $activityStatus = true;
            event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, $activityStatus));
            return  redirect()->route('config.court')->with('success', 'Court '. $court->name.'was deleted.');
        }else{
            $activityDescription = 'Failed to delete court';
            $activityAction = 'delete';
            $activityStatus = false;
            event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, $activityStatus));
            return  redirect()->back()->with('error', 'Failed to delete court '. $court->name);
        }

    }
}
