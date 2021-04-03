<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    public function getLoginUserDetail(){
        $data=[];
        try {
            $user = Auth::user();
            $data = [
                "id"=>$user->id,
                "fullname"=>$user->fullname(),
                "email"=>$user->email,
                "role"=>$user->role
            ];
        }catch (\Exception $exception){
            Log::error("AuthController",['method'=>'getLoginUserDetail', "error"=>$exception->getMessage()]);
        }

        return response()->json(["status"=>true, 'data'=>$data], 200);
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email|max:255',
            'password' => 'required',
        ]);

        try {

            if (! $token = $this->jwt->attempt($request->only('email', 'password'))) {
                return response()->json(['status'=>false, 'message'=>"Invalid login credentials"], 403);
            }

            $user = Auth::user();

            $data = [
                "id"=>$user->id,
                "fullname"=>$user->fullname(),
                "email"=>$user->email,
                "role"=>$user->role,
                "status"=> $user->status==true
            ];
            //if user deactivated

            if ($user->status == false)
                return response()->json(['status'=>false, 'message'=>'Your account has been deactivated'], 403);

        } catch (\Exception $exception) {
            Log::error("AuthController", ["login"=>$exception->getMessage()]);

            return response()->json(['status'=>false, 'message' => $exception->getMessage()], 403);
        }

        return response()->json(["status"=>true, 'data'=>$data, 'token'=>$token], 200);
    }

    public function getAuthenticatedUser()
    {
        try {
            if (! $user = $this->jwt->parseToken($this->jwt->getToken())->authenticate()->role) {
                return response()->json(['status'=>false, 'message' => 'user not found'], 403);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['status'=>false, 'message' => 'token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['status'=>false, 'message' => 'token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['status'=>false, 'message' => 'token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }

    public function getAllRoles(){
        $roles = Role::all();
        return response()->json(["status"=>true,"data"=>$roles ], 200);
    }

    public function changePassword(Request $request){
        $this->validate($request,[
           'current_password'=>'required',
           'new_password'=>'required|min:6',
           'confirm_password'=>'required'
        ]);
        $currentPassword = $request->current_password;
        $newPassword = $request->new_password;
        $confirmPassword = $request->confirm_password;

        if($confirmPassword != $newPassword){
            return response()->json(['status'=>false, 'message'=>'Passwords does not match'], 403);
        }
        //check current password
        if (!(Hash::check($currentPassword, Auth::user()->password))) {
            return response()->json(['status'=>false, 'message'=>'Your current password does not matches with the password you provided'], 403);
        }

        if(strcmp($currentPassword, $newPassword) == 0){
            return response()->json(['status'=>false, 'message'=>'New Password cannot be same as your current password. Please choose a different password'], 403);
        }

        //Change Password
        $user = Auth::user();
        $user->password = Hash::make($newPassword);
        $user->save();
        return response()->json(['status'=>true, 'message'=>'Password changed successfully!'],201);

    }

    public function logout(){
        auth()->invalidate(true);
        return response()->json(["status"=>true, "message"=>"Logout successful"],201);
    }
}
