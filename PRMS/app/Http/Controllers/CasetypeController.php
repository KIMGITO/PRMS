<?php

namespace App\Http\Controllers;

use App\Models\Casetype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Events\ActivityProcessed;


class CasetypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = Casetype::all();
        return view('system.config.case-types', ['types' => $types]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'initials' => 'required|unique:casetypes,initials',
            'caseType' => 'required|unique:casetypes,case_type',
            'duration' => 'required|integer'
        ], [
            'required' => ':attribute required.',
            'integer' => ':attribute must be a number.',
            'unique' => ':attribute already exists.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $case = new Casetype();
        $case->initials = $request->input('initials');
        $case->case_type = $request->input('caseType');
        $case->duration = $request->input('duration');

        $activityDescription = 'Created a new casetype';
        $activityAction = 'create';
        $activityStatus = true;

        if ($case->save()) {
            event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, $activityStatus));
            return  redirect()->back()->with('success', 'New CaseType ,' . $request->input('caseType') . ' Was added.');
        } else {
            event(new ActivityProcessed(auth()->user()->id, 'Failed to create a new casetype', 'create', false));
            return  redirect()->back()->with('error', 'Error occurred when adding,' . $request->input('caseType'));
        }
    }
}