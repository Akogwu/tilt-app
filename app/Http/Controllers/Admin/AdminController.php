<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SchoolDetailResource;
use App\Http\Resources\UsersResource;
use App\Models\PrivateLearner;
use App\Models\Role;
use App\Models\School;
use App\Models\SchoolAdmin;
use App\Models\Student;
use App\Models\TestRecord;
use App\Models\TestResult;
use App\Models\Transaction;
use App\Models\User;
use App\Util\GeneralUtil;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
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
                'image'=>$latestTest->session->user->image_url ?? GeneralUtil::DEFAULT_IMAGE_PLACEHOLDER_URL,
            ];
        }

        $bestPerformingSchool = $this->getBestPerformingSchool();
        $data = [
            'total_students'=>$totalStudents,
            'total_school'=>$totalSchools,
            'total_test_taken'=>$totalTestTaken,
            'latest_test'=>  $this->paginate($latestTestData),
            'schools'=>$bestPerformingSchool,
            'successful_transaction'=>$successfulTransaction
        ];
        //dd($bestPerformingSchool);
        return view('pages.admin.dashboard',compact('data'));
    }

    public function paginate($items, $perPage = 5, $page = null, $options = []){
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    private function getBestPerformingSchool(){
        //get performing schools
        $students = DB::table('schools')
            ->join('students', 'students.school_id','=', 'schools.id')
            ->join('user_sessions AS sessions', 'students.user_id','=', 'sessions.user_id')
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
        $admins = User::where('role_id', $role->id)->paginate($row);

        return view('pages.admin.admin', compact('admins'));

        //return UsersResource::collection($users);
    }

    public function getAllPrivateLearner(){
        $row= 10;
        $role = Role::where('role', 'PRIVATE_LEARNER')->first();
        $privateLearners = PrivateLearner::join('users','private_learners.user_id','=','users.id')
            ->where('users.status', 1)->orderBy('users.name', 'asc')
        ->paginate($row);

        return view('pages.admin.private-learner', compact('privateLearners'));
    }

    public function getTransaction(){
        $data=[
            "total"=>0,
            "failed"=>0,
            "success"=>0,
            "total_funds"=>'0.00'
            ];
        return view('pages.admin.transaction', compact('data'));
    }

    public function getAllSchool(){
        $schools = School::orderBy('name','asc')->get();
        return view('pages.school.schools',compact('schools'));
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
