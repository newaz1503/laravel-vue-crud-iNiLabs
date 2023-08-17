<?php

namespace App\Http\Controllers\Admin;

use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Student;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request){
        if($request->format() == 'html'){
            return view('layouts.admin.app');
        }
        $users = User::count();
        $students = Student::count();
        return response()->json([
            'users' => $users,
            'students' => $students
        ]);
    }
}
