<?php

namespace App\Http\Controllers\Admin;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function index(Request $request){
        if($request->format() == 'html'){
            return view('layouts.admin.app');
        }
        $students = Student::orderBy('id','Desc')->get();
        return response()->json($students);
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'bail|required|string|max:255',
            'email' => 'bail|required|email|max:100|unique:students'
        ]);
        Student::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        return response()->json([
            'status' => 200,
            'msg' => 'Student Stored'
        ]);
    }
    public function update(Request $request, $id){
        $this->validate($request, [
            'name' => 'bail|required|string|max:255',
            'email' => 'bail|required|email|max:100|unique:students,email,'.$id
        ]);
        Student::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        return response()->json([
            'status' => 200,
            'msg' => 'Student Updated'
        ]);
    }

    public function destroy($id){
        $student = Student::findOrFail($id);
        if($student){
            $student->delete();
        }else{
            return response()->json([
                'Student not found'
            ], 404);
        }
        return response()->json([
            'msg' => 'Student deleted'
        ], 200);

    }

}
