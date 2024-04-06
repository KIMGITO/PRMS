<?php

namespace App\Http\Controllers;

use App\Models\Casetype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CasetypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $types = Casetype::all();
        return view('system.config.case-types',['types'=>$types]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // return view('system.config.case-types');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'initials'=>'required|unique:casetypes,initials',
            'caseType'=>'required|unique:casetypes,case_type',
            'duration'=>'required|integer'
        ],[
            'required'=>':attribute required.',
            'integer'=>':attribute must be a number.',
            'unique'=>':attribute already exists.',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $case = New Casetype();
        $case->initials = $request->input('initials');
        $case->case_type = $request->input('caseType');
        $case->duration = $request->input('duration');

        if($case->save()){
            return  redirect()->back()->with('success','New CaseType ,'.$request->input('caseType').' Was added.');
        }else{
            return  redirect()->back()->with('error','Error occured when adding,'.$request->input('caseType'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Casetype $casetype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Casetype $casetype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Casetype $casetype)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Casetype $casetype)
    {
        //
    }
}
