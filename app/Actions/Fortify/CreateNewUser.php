<?php

namespace App\Actions\Fortify;

use App\Models\PrivateLearner;
use App\Models\School;
use App\Models\SchoolAdmin;
use App\Models\Session;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;


    /**
     * Create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        return DB::transaction(function () use ($input) {
            //dd($input['firstname']);
            return tap(User::create([
                'name' => $input['lastname'].' '.$input['firstname'],
                'first_name' => $input['firstname'],
                'last_name' => $input['lastname'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'role_id' => $input['role_id'],
                'password' => Hash::make($input['password']),
            ]), function (User $user) use ($input) {

                //PRIVATE_LEARNER
                if ($input['role_id'] == 'PRIVATE_LEARNER'){

                    $privateLearner = PrivateLearner::createNewOrUpdate($input,$user);
                    //check for session
                    $sessionId = $input['session_id'] ?? null;

                    if ($sessionId){
                        //update users session
                        $session = Session::where('id', $sessionId)->first();
                        //session is not null and session is valid
                        if ($session !=null && $session->valid)
                            $session->update(['user_id'=>$user->id,'valid'=>false]);
                        //else do nothing
                    }

                }
                if (($input['role_id'] == 'SCHOOL_ADMIN')){
                    $school = School::createNew($input);
                    SchoolAdmin::createNew($user->id, $school->id);
                }

//                if ($input['role_id'] == 'PRIVATE_LEARNER'):
//                    PrivateLearner::createNewOrUpdate($input,$user);
//                elseif ($input['role_id'] == 'SCHOOL_ADMIN'):
//                    $school = School::createNew($input);
//                    SchoolAdmin::createNew($user->id, $school->id);
//                endif;
                $this->createTeam($user);
            });
        });
    }

    /**
     * Create a personal team for the user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    protected function createTeam(User $user)
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
    }


}
