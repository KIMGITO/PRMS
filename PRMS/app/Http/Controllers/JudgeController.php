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

    
}
