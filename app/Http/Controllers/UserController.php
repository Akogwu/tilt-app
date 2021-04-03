<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Http\Resources\UsersResource;
use App\PrivateLearner;
use App\Student;
use App\User;
use App\Util\ImageUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function getUsers(){
        $users = User::all();
        return UsersResource::collection($users);
    }
    //Admin
    public function deactivateUser($userId){
        $user = User::find($userId);
        if($user ==null)
            return response()->json(['status'=>false, 'message'=>'user not found'], 404);

        $user->update(['status'=>false]);
        return response()->json(['status'=>true, 'message'=>'Action successful'], 201);
    }
    //Admin
    public function activateUser($userId){
        $user = User::find($userId);
        if($user ==null)
            return response()->json(['status'=>false, 'message'=>'user not found'], 404);

        $user->update(['status'=>true]);
        return response()->json(['status'=>true, 'message'=>'Action successful'], 201);
    }

    //getSingleUser
    public function getSingleUser($userId){
        $user = User::find($userId);
        if($user ==null)
            return response()->json(['status'=>false, 'message'=>'user not found'], 404);
        if ($user->role->role =="STUDENT")
            return $user->student->detail();

        if ($user->role->role =="SCHOOL_ADMIN")
            return $user->schoolAdmin->detail();
        //for private learners and admin users
        return new UsersResource($user);

    }
    //change email
    public function updateProfile(Request $request, $userId=null){
        $userRules = [
            'first_name'=>'nullable|string',
            'last_name'=>'nullable|string',
            'middle_name'=>'nullable|string',
            'email'=>'nullable|email',
            'phone_number'=>'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
            'password'=>'nullable',
        ];
        $privateLearner = [
            'age'=>'nullable|string',
            'level'=>'nullable|string',
            'gender'=>'nullable|string',
            'school'=>'nullable|string',
        ];
        if ($userId !=null){
            $user = User::find($userId);
            if($user ==null)
                return response()->json(['status'=>false, 'message'=>'user not found'], 404);
        }else
            $user = Auth::user();

        try {
            $validator = validator($request->all(), $userRules)->validate();
            if ($request->has('email')){
                //check if email already exists
                $checkEmail = User::where([
                    ['email', $request->email],
                    ['id','!=', $user->id]
                    ])->count();
                if ($checkEmail > 0)
                    return response()->json(['status'=>false, 'message'=> "Email already exist"],409);
            }
            if ($request->has('password')){
                $password = Hash::make($request->password);
                $validator['password'] = $password;
            }

            //Check if private learner
            if ($user->role->role =="PRIVATE_LEARNER"){
                $privateLearnerValidator = validator($request->all(), $privateLearner)->validate();
                PrivateLearner::createNewOrUpdate((object)$privateLearnerValidator, $user->id);
            }
            $user->update($validator);

        }catch (\Exception $exception){
            return response()->json(['status'=>false, 'message'=> $exception->getMessage()],422);
        }

        return response()->json(['status'=>true, 'message'=>'Update successful'],201);
    }
    //update profile picture
    public function updateProfileImage(Request $request){
        $this->validate($request,[
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',
        ]);
        $imageUrl = ImageUploader::upload($request);
       $user = Auth::user();
       if ($imageUrl !=null){
            $user->update([
                'image_url'=>$imageUrl
            ]);
            return response()->json(['status'=>true, 'message'=>'Update successful'],201);
        }
       return response()->json(['status'=>false, 'message'=>'Image Upload failed'], 400);

    }
    //delete account
    public function deleteProfile($userId = null){
        //admin user
        if ($userId != null){
            $user = User::find($userId);
            if ($user == null)
                return response()->json(['status'=>false, 'message'=>'user not found'], 404);
        }else{
            $user = Auth::user();
        }
        $user->delete();
    }
    public function getAllStudent(){

       return StudentResource::collection(Student::all());

    }

}
