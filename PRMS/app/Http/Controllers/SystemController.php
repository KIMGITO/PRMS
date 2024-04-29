<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use App\Events\ActivityProcessed;

class SystemController extends Controller
{
    public function department(){
        $departments=Department::all();
        return view('system.departments.departments',[
           'data' =>$departments
        ]);
    }


public function storeDepartment(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => ['required', 'string', 'unique:departments,name']
    ], [
        'name.required' => 'A department name is required to continue.',
        'name.unique' => 'A similar department name already exists.'
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $department = new Department();
    $department->name = $request->input('name');

    if ($department->save()) {
        // Log the activity of adding a new department
        $activityDescription = 'New Department added: ' . $request->input('name');
        $activityAction = 'add';
        event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, true));

        return redirect()->back()->with('success', 'Department was added successfully');
    } else {
        // Log the error when adding a new department
        $activityDescription = 'Failed to add department: ' . $request->input('name');
        $activityAction = 'error';
        event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, false));

        return redirect()->back()->with('error', 'An error occurred when adding the department');
    }
}

    public function editDepartment(Request $request, Department $department, $id)
{
    try {
        $id = decrypt($id);
        $department = Department::where('id', $id)->firstOrFail();
        return view('system.departments.department-edit', ['data' => $department]);
    } catch (\Throwable $th) {
        abort(404, 'File Not Found');
    }
}

    public function destroyDepartment(Department $department, $id)
{
    try {
        $id = decrypt($id);
    } catch (\Throwable $th) {
        abort(404, 'File Not Found');
    }
        $department = Department::find($id);
       
        if ($department->delete()) {
            // Log the activity of removing a department
            // dd($department);
            $activityDescription = 'Department removed: ' . $department->name;
            $activityAction = 'remove';
            event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, true));

            return redirect()->route('new.department')->with('warning', 'Caution!! Department was removed.');
        } else {
            return redirect()->route('new.department')->with('error', 'Failed to remove the department.');
        }
    
}

    public function updateDepartment(Request $request, $id)
{
    try {
        $id = decrypt($id);
    } catch (\Throwable $th) {
        abort(404);
    }
        $department = Department::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:departments,name,' . $id,
        ], [
            'name.unique' => 'The department already exists.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $oldName = $department->name;
        $department->name = $request->input('name');
        if ($department->save()) {
            // Log the activity of updating a department
            $activityDescription = 'Department updated: ' . $oldName . ' to ' . $request->input('name');
            $activityAction = 'update';
            event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, true));

            return redirect()->route('new.department')->with('success', 'Department Updated Successfully');
        } else {
            // Log the error when updating a department
            $activityDescription = 'Failed to update department: ' . $oldName;
            $activityAction = 'error';
            event(new ActivityProcessed(auth()->user()->id, $activityDescription, $activityAction, false));

            return redirect()->route('new.department')->with('error', 'Failed to update the department.');
        }
    
}

    public function back($url){ 
        try {
            $url  = str_replace('-', '/', $url);
            return redirect($url);
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }

    
}
