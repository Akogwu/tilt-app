<?php

namespace App\Http\Controllers;

use App\Models\SchoolAdmin;
use App\Models\Session;
use App\Models\Student;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolAdminController extends Controller
{
    public function index(){
        return view('schools');
    }

    public function dashboard(){
        $schoolAdminId = Auth::id();
        $schoolAdmin = SchoolAdmin::where('user_id', $schoolAdminId)->first();
        if ($schoolAdmin ==null)
            return response()->json(['status'=>false, 'message'=>'School-Admin Id '.$schoolAdminId.' not found'], 404);
        //school ddetails
        $studentIds = $schoolAdmin->school->student->pluck('user_id');
        $sessionCount = Session::whereIn('user_id', $studentIds)->count();
        $transaction = Transaction::where([['payment_type','school_capacity'],'payment_for'=>$schoolAdmin->school_id],['status'=>true])->count();
        $students = Student::whereIn('user_id', $studentIds)->get();

        if ($students !=null)
            $students = $students->map(function ($student){
                return $student->schema();
            });
        $data = [
            'school'=>$schoolAdmin->school->schema(),
            'total_test'=> $sessionCount,
            'total_transactions'=> $transaction,
            'students'=>$students,
        ];
        return view('pages.school.dashboard',compact('data'));
    }
    //only admin and school_admin
    public function getSchoolAdmin($schoolAdminId){
        $schoolAdmin = SchoolAdmin::where('user_id', $schoolAdminId)->first();
        if ($schoolAdmin ==null)
            return response()->json(['status'=>false, 'message'=>'School-Admin Id '.$schoolAdminId.' not found'], 404);
        return response()->json($schoolAdmin->detail(), 200);
    }

    public function requestDelete(Request $request, $studentId){
        $action = $request->query('action');
        //validate query param
        if (is_null($action) || !in_array($action, [1,0]))
            return response()->json(['status'=>false, 'message'=>'action query parameter is required'], 400);
        //validate student
        $student = Student::where('user_id', $studentId)->first();
        if (is_null($student))
            return response()->json(['status'=>false, 'message'=>'student not found'], 404);

        $student->update(['request_delete'=>$action]);

        return response()->json(['status'=>true, 'message'=>'update successful'], 202);

    }
}
