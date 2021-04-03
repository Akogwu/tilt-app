<?php

namespace App\Http\Controllers;

use App\Notifications\AllUsersNotification;
use App\Notifications\PrivateLearnerNotification;
use App\Notifications\SchoolAdminNotification;
use App\Notifications\UserNotification;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;

class NotificationController extends Controller
{
    public function create(Request $request){
        $this->validate($request,[
           'group'=>['required','array', Rule::in(["all","private_learner","school_admin"])],
           'message'=>'required'
        ]);

        if (in_array("all", $request->group)){
            //get priv_learner and school admin roleId
            $roleIds = Role::whereIn('role',['SCHOOL_ADMIN','PRIVATE_LEARNER'])->pluck('id');
            $users = User::whereIn('role_id', $roleIds)->get();
            Notification::send($users, new AllUsersNotification($request->message));
            return response()->json(['status'=>true, 'message'=>'action successful'], 200);
        }
        if (in_array("private_learner", $request->group)){
            $roleId = Role::where('role', 'PRIVATE_LEARNER')->pluck('id');
            $users = User::whereIn('role_id', $roleId)->get();
            Notification::send($users, new PrivateLearnerNotification($request->message));
        }
        if (in_array("school_admin", $request->group)){
            $roleId = Role::where('role', 'SCHOOL_ADMIN')->pluck('id');
            $users = User::whereIn('role_id', $roleId)->get();
            Notification::send($users, new SchoolAdminNotification($request->message));
        }

        return response()->json(['status'=>true, 'message'=>'action successful'], 200);

    }

    public function myNotification($userId){
        $user = User::find($userId);
        return $user->notifications;
    }


}
