<?php

namespace App\Http\Controllers;

use App\Models\Purpose;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurposeController extends Controller
{
    public function index(){
        $purpose = Purpose::all();
        return view('system.config.purpose',['data'=>$purpose]);
    }

    public function store(Request $request){
        
        $validator = Validator::make($request->all(),[
            'purpose' =>'required|string|max:50|unique:purposes,purpose',
            'supervision'=>'required',
            'description'=>'required|max:250'
        ],[
            'description.required'=>'Givea simple explanation of the Request Purpose.'
        ]);

        if($validator->fails()){
            
           return redirect()->back()->withErrors($validator)->withInput();
        }

        $reason = New Purpose();
        $reason->purpose = $request->input('purpose');
        $reason->supervised = $request->input('supervision');
        $reason->description = $request->input('description');
        // dd($request->input('supervision'));
        
        if($reason->save()){
            return redirect()->back()->with('success','New Purpose has been added successfully');
        }else{
            return redirect()->back()->with('error','Failed to add '.$request->purpose.' To purposes.');
        }

    }
    
}
