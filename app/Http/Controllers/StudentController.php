<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Repository\TestResultRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use function GuzzleHttp\Promise\all;

class StudentController extends Controller
{
    //ajax request
    public function getSingle($userId){
        $student = Student::where('user_id', $userId)->first();
        return response()->json($student->detail());
    }

    public function getSingleStudent($userId){
        $user = User::find($userId);
        if (!$user)
            abort(404);

        $testResultRepo = new TestResultRepository();
        $testResults = $testResultRepo->getMyTestResults($user->id);
        $testDetail = $testResultRepo->getTestDetails($user->id);

        return view('pages.school.admin.single-student', compact('user','testResults','testDetail'));

    }

    //change email
    public function updateProfile(Request $request, $userId){

        $userRules = [
            'first_name'=>'nullable|string',
            'last_name'=>'nullable|string',
            'middle_name'=>'nullable|string',
            'email'=>'nullable|email',
            'phone_number'=>'nullable',
        ];
        $studentRules = [
            'age'=>'nullable|string',
            'level'=>'nullable|string',
            'gender'=>'nullable|string',
        ];
            $user = User::find($userId);
            if($user ==null)
                return response()->json(['status'=>false, 'message'=>'user not found'], 404);


        try {
            //if true
            if ($request->edit_password){
                $userRules = array_merge($userRules, [
                    'password'=>'required|confirmed',
                ]);
            }else{

            }
            $userValidator = $this->validateRequest($request->all(), $userRules);
            $studentValidator = $this->validateRequest($request->all(), $studentRules);

            if ($request->has('email')){
                //check if email already exists
                $checkEmail = User::where([
                    ['email', $request->email],
                    ['id','!=', $user->id]
                ])->count();
                if ($checkEmail > 0)
                    return response()->json(['status'=>false, 'message'=> "Email already exist"],409);
            }
            if ($request->edit_password){
                $password = Hash::make($request->password);
                $userValidator['password'] = $password;
            }

            $user->update($userValidator);
            //update student
            $user->student->update($studentValidator);
        }catch (\Exception $exception){
            return response()->json(['status'=>false, 'message'=> $exception->getMessage()]);
        }

        return response()->json(['status'=>true, 'message'=>'Update successful'],201);
    }


    //Only Admin can delete
    public function delete(Request $request){
        $this->validate($request, [
           'student_ids'=>'required | array'
        ]);
        //return $request->student_ids;

        foreach ($request->student_ids as $studentId){
            $student = Student::where('user_id', $studentId)->first();
            if ($student == null)
                continue;
            try {
                //delete as user
                User::where('id', $studentId)->delete();
                $student->delete();
            }catch (\Exception $exception){
                Log::error('StudentController', ['method'=>'delete()', 'message'=>$exception->getMessage()]);
                return response()->json(['status'=>false, 'message'=> $exception->getMessage()], 500);
            }
        }
        return response()->json(['status'=>true, 'message'=>'Deleted successfully'], 202);
    }


    public function getAllRequestDelete(){
        $schoolId = \request('school_id');
        if (!is_null($schoolId) && !empty($schoolId)){
            $students = Student::where([['school_id', $schoolId],['request_delete', true]])->get();
        }else
        $students = Student::where('request_delete', true)->get();

        return $students->map(function ($student){
           return $student->detail();
        });
    }

    private function validateRequest($request, $rules){
        return $userValidator = validator($request, $rules)->validate();
    }
}
