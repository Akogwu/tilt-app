<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SchoolDetailResource;
use App\Http\Resources\UsersResource;
use App\Role;
use App\School;
use App\SchoolAdmin;
use App\Student;
use App\TestRecord;
use App\TestResult;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard(){
        $totalStudents = Student::count();
        $totalSchools = School::count();
        $totalTestTaken = TestRecord::distinct('session_id')->count();
        $latestTests = TestResult::latest()->limit(10)->get();
        $successfulTransaction = Transaction::count();
        $latestTestData = [];
        foreach ($latestTests as $latestTest){
            $latestTestData[] = [
              'name'=>$latestTest->session->user->fullname() ?? '',
                'percentage'=>$latestTest->avg_score,
                'date'=>$latestTest->created_at->diffForHumans(),
            ];
        }

        $bestPerformingSchool = $this->getBestPerformingSchool();

        return [
            'total_students'=>$totalStudents,
            'total_school'=>$totalSchools,
            'total_test_taken'=>$totalTestTaken,
            'latest_test'=>$latestTestData,
            'schools'=>$bestPerformingSchool,
            'successful_transaction'=>$successfulTransaction
        ];
    }
    private function getBestPerformingSchool(){
        //get performing schools
        $students = DB::table('schools')
            ->join('students', 'students.school_id','=', 'schools.id')
            ->join('sessions', 'students.user_id','=', 'sessions.user_id')
            ->join('test_results', 'test_results.session_id', '=', 'sessions.id')
            ->orderBy('schools.name')
            ->select('schools.name','schools.address','schools.state','schools.country', 'test_results.avg_score')
            ->get()
            ->groupBy('name');

        if ($students->count() == 0)
            return [];

        $data = array();
        foreach ($students as $student=>$value ){
            $school = $value->take(1)[0];
            $data[]= [
                'school_name'=> $student,
                "location"=>$school->address .', '.$school->state.', '.$school->country,
                "total_test_taken"=>$value->count()
            ];
        }
        //sort in ascending order and take the first 10
        return collect($data)->sortBy('total_test_taken')->reverse()->take(10)->toArray();
}

    public function getAllAdmin(){
        $row= 10;
        $role = Role::where('role', 'ADMIN')->first();
        $users = User::where('role_id', $role->id)->paginate($row);
        return UsersResource::collection($users);
    }

    public function getAllPrivateLearner(){
        $row= 10;
        $role = Role::where('role', 'PRIVATE_LEARNER')->first();
        $users = User::where('role_id', $role->id)->paginate($row);
        return UsersResource::collection($users);
    }

    public function getAllSchool(){
        $school = School::orderBy('name','asc')->get();
        return SchoolDetailResource::collection($school);
    }

    public function userManagementDashboard(){
        $role = Role::where('role', 'ADMIN')->first();
        $adminCount = User::where('role_id', $role->id)->count();

        $role = Role::where('role', 'PRIVATE_LEARNER')->first();
        $learnerCount = User::where('role_id', $role->id)->count();
        $schoolCount = School::count();
        $data = [
          'admin_count'=>$adminCount,
          'learner_count'=>$learnerCount,
          'school'=>$schoolCount
        ];
        return response()->json(['data'=>$data]);
    }
}