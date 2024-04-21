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
}
