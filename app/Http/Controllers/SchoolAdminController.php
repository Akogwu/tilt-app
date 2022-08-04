<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\SchoolAdmin;
use App\Models\Session;
use App\Models\Settings;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\User;
use App\Repository\TestResultRepository;
use App\Repository\TransactionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolAdminController extends Controller
{
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function index(){
        return view('schools');
    }

    public function dashboard() {

        $schoolAdminId = Auth::id();
        $schoolAdmin = SchoolAdmin::where('user_id', $schoolAdminId)->first();

        if ($schoolAdmin ==null)
            abort(404, 'No school found');

        //school ddetails
        $studentIds = $schoolAdmin->school->student->pluck('user_id');
        $sessionCount = Session::whereIn('user_id', $studentIds)->count();
        $transaction = Transaction::where([
            ['payment_type','school_capacity'],
            ['payment_for', $schoolAdmin->school_id],
            ['status', true]
        ])->count();
        $students = Student::where('school_id', $schoolAdmin->school_id);

        $data = [
            'school' => $schoolAdmin->school->schema(),
            'total_test' => $sessionCount,
            'total_transactions' => $transaction,
            'students' => $students->latest()->limit(10)->get(),
            'total_students' => $students->count(),
            'school_capacity' => $schoolAdmin->school->school_capacity,
            'INDIVIDUAL_STUDENT_FLAT_RATE' => Settings::getValue('INDIVIDUAL_STUDENT_FLAT_RATE')
        ];

        return view('pages.school.admin.dashboard',compact('data'));
    }

   /* //only admin and school_admin
    public function getSchoolAdmin($schoolAdminId){
        $schoolAdmin = SchoolAdmin::where('user_id', $schoolAdminId)->first();
        if ($schoolAdmin ==null)
            return response()->json(['status'=>false, 'message'=>'School-Admin Id '.$schoolAdminId.' not found'], 404);
        return response()->json($schoolAdmin->detail(), 200);
    }*/

    public function getTransaction(){
        $schoolAdmin = Auth::user()->schoolAdmin;
        $schoolName = $schoolAdmin->school->name;
        $schoolId = $schoolAdmin->school_id;

        $transactionDetail = $this->transactionRepository->transactionHistory($schoolId,'school');

        return view('pages.school.admin.transaction', compact('transactionDetail','schoolName'));
    }

    public function getStudents(){
        $schoolAdmin = Auth::user()->schoolAdmin;
        $schoolName = $schoolAdmin->school->name;
        $schoolId = $schoolAdmin->school_id;
        $students = Student::where('school_id',$schoolAdmin->school->id)->paginate(10);

        return view('pages.school.admin.student',
            compact('schoolName','schoolId','students')
        );
    }

    public function requestDelete(Request $request, $studentId){
        $action = $request->action;

        //validate query param
        if (is_null($action) || !in_array($action, [1,0,-1]))
            return response()->json(['status'=>false, 'message'=>'action query parameter is required'], 400);
        //validate student
        $student = Student::where('user_id', $studentId)->first();
        if (is_null($student))
            return response()->json(['status'=>false, 'message'=>'student not found'], 404);

        $student->update(['request_delete'=>$action]);

        return response()->json(['status'=>true, 'message'=>'update successful'], 202);

    }
}
