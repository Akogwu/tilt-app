<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\PrivateLearner;
use App\Models\Role;
use App\Models\School;
use App\Models\SchoolAdmin;
use App\Models\Session;
use App\Models\Student;
use App\Models\Subscription;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RegistrationController extends Controller
{

    public function index(){
        $countries = Country::all();
        dd($countries);

       // return view('pages.contact',compact('countries'));
    }

    public function showRegistrationForm()
    {
        $countries = Country::all();
        dd($countries);
        return view('auth.register', compact('countries'));
    }


    public function createSchool(){
        $countries = Country::all();
        return view('pages.school.create',compact('countries'));
    }


    public function admin(Request $request){
        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        //find already existing email
        if ($this->emailExist($request->email))
            return response()->json(['status'=> false,"message"=>"Email already exist"], 403);
        //get admin role
        $role = Role::where('role','ADMIN')->first();
        //add to request object
        $request->request->add(['role_id' => $role->id]);

        $user = User::createNew($request);
        //TODO send mail

        return response()->json(['status'=>true, 'message'=>"Registration Successful"], 201);
    }
    public function privateLeaner(Request $request){
        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'gender' => 'required|string',
            'age' => 'required',
            'level' => 'required|string',
            'school' => 'required|string',
            'country_id' => 'required|numeric',
            'state_id' => 'required|numeric',
            'password' => 'required|string',
        ]);
        //find already existing email
        if ($this->emailExist($request->email))
            return response()->json(['status'=> false,"message"=>"Email already exist"], 403);
        //already have a test session as anonymous user
        $session = null;
        if ($request->session_id){
            //update users session
            $session = Session::where('id', $request->session_id)->first();
            if ($session ==null)
                return response()->json(['status'=> false, "message"=>"SessionId is not found"], 403);
        }

        //get admin role
        $role = Role::where('role','PRIVATE_LEARNER')->first();
        //add to request object
        $request->request->add(['role_id' => $role->id]);
        $user = User::createNew($request);
        PrivateLearner::createNewOrUpdate($request, $user->id);

        //update session
        if ($session)
            $session->update(['user_id'=>$user->id]);

        //TODO send mail

        return response()->json(['status'=>true, 'message'=>"Registration Successful"], 201);
    }
    //TODO update image for all users
    public function school(Request $request){
        $this->validate($request, [
            'school_name' => 'required|string',
            'school_description' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($this->emailExist($request->email))
            return response()->json(['status'=> false,"message"=>"Email already exist"], 403);
        //get school admin role
        $role = Role::where('role','SCHOOL_ADMIN')->first();
        //add to request object
        $request->request->add(['role_id' => $role->id]);
        $user = User::createNew($request);

        $school = School::createNew($request);
        SchoolAdmin::createNew($user->id, $school->id);

        //TODO send mail

        return redirect()->route('schools.index');
        //response()->json(['status'=> true,"message"=>"Registration Successful"], 201);
    }



    public function student(Request $request){

        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
            'age' => 'required',
            'level' => 'required',
            'gender' => 'required',
            'school_id' => 'required|exists:schools,id'
        ]);

        if ($this->emailExist($request->email))
            return response()->json(['status'=> false,"message"=>"Email already exist"], 403);
        //get school admin role
        $role = Role::where('role','STUDENT')->first();
        //add to request object
        $request->request->add(['role_id' => $role->id]);

        //check if school exist
        $schoolId = $request->school_id;
        $school = School::find($schoolId);
        if ($school == null)
            return response()->json(['status'=>false, 'message'=>'School not found'], 400);
        //check if school subscription has capacity for this student
        if ($school->getRemainingCapacity() < 1)
            return response()->json(['status'=>false, 'message'=>'Maximum student capacity reached'], 400);
        try {
            $user = User::createNew($request);
            Student::createNew($user->id, $schoolId, $request);
            $school->decrement('school_capacity', 1);
        }catch (\Exception $exception){
            Log::error('RegistrationController', ['school'=>$exception->getMessage()]);
            return response()->json(['status'=>false, 'message'=>$exception->getMessage()], 400);
        }

        //return $user;
        return response()->json(['status'=>true, 'message'=>"Registration Successful"], 201);

    }

    private function emailExist($email){
        try {
            $user = User::where('email', $email)->first();
            if ($user != null)
                return true;
            return false;
        }catch (\Exception $exception){
            Log::error('RegistrationController', ["emailExist"=>$exception->getMessage()]);
            return false;
        }
    }
}
