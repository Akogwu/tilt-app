<?php


namespace App\Http\Responses;
use Illuminate\Http\Response;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {

        if ($request->role_id == 'ADMIN') {
            return redirect(config('fortify.home'));
        }
        if ($request->role_id == 'PRIVATE_LEARNER') {
            return redirect(config('fortify.private'));
        }
        if ($request->role_id == 'SCHOOL_ADMIN') {
            return redirect(config('fortify.school'));
        }
        if ($request->role_id == 'STUDENT') {
            return redirect(config('fortify.private'));
        }
//        return $request->wantsJson()
//            ? new Response('', 201)
//            : redirect(config('fortify.registered'));
    }
}
