<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SystemController extends Controller
{
    public function department(){
        $departments=Department::all();
        return view('system.departments.departments',[
           'data' =>$departments
        ]);
    }

    public function storeDepartment(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>['required','string','unique:departments,name']
        ],[
            'name.required'=>'A department name is required to continue.',
            'name.unique'=>'A similar department name already exists.'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $department = new Department();
        $department->name=$request->input('name');

        if($department->save()){
            return redirect()->back()->with('success','Department was added successfully');
        }else{
            return redirect()->back()->with('error','An error occured when adding the department');
        }
    }

    public function editDepartment(Request $request,Department $department, $id){
        try {
            $id = decrypt($id);
            $department = Department::where('id',$id)->firstOrFail();
            return view('system.departments.department-edit',['data'=>$department]);
        } catch (\Throwable $th) {
            abort(404,'FIle Not Found');
        }
        
    }

    public function destroyDepartment(Department $department, $id){
        try {
            $id = decrypt($id);
            $department = Department::where('id',$id)->firstOrFail();
            if($department->delete()){
                return redirect()->route('new.department')->with('warning','Caution!! Department was removed.');
            }else{
                return redirect()->route('new.department', ['error' => 'Failed to remove the department.']);
            }
        } catch (\Throwable $th) {
            abort(404,'FIle Not Found');
        }
        
    }

    public function updateDepartment(Request $request,$id){
        try {
            $id = decrypt($id);
            $department = Department::findOrFail($id);
            $validator = Validator::make($request->all(),[
                'name'=>'required|unique:departments,name,'.$id,
            ],[
                'name.unique'=>'The department already exists.'
            ]);
            
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $department->name = $request->input('name');
            if($department->save()){
                return redirect()->route('new.department')->with('success','Department Updated Successfully');
            }else{
                return redirect()->route('new.department')->with('error','Failed to update the department.');
            }

        } catch (\Throwable $th) {
            abort(404);
        }
        
    }
}
