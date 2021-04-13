<?php

namespace App\Http\Controllers;
use App\Http\Resources\SchoolDetailResource;
use App\Http\Resources\StudentResource;
use App\Models\Country;
use App\Models\School;
use App\Models\SchoolAdmin;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class SchoolController extends Controller
{

    public function updateSchool(Request $request, $schoolId){
        $rules = [
            'school_name'=>'nullable|string',
            'school_description'=>'nullable|string',
            'school_address'=>'nullable|string',
            'school_country'=>'nullable|string',
            'school_state'=>'nullable|string',
            'school_city'=>'nullable|string',
            'school_zipcode'=>'nullable|string',
        ];

        try {
            $school = School::findOrFail($schoolId);
        }catch (\Exception $exception){
            return response()->json(['status'=>false, 'message'=>'School Id '.$schoolId.' not found'], 404);
        }

        validator($request->all(), $rules)->validate();
        $data = [
            'name'=>is_null($request->school_name) ? $school->name: $request->school_name,
            'description'=>is_null($request->school_description) ? $school->description: $request->school_description,
            'address'=>is_null($request->school_address) ? $school->address: $request->school_address,
            'country'=>is_null($request->school_country) ? $school->country: $request->school_country,
            'state'=>is_null($request->school_state) ? $school->state: $request->school_state,
            'city'=>is_null($request->school_city) ? $school->city: $request->school_city,
            'zipcode'=>is_null($request->school_zipcode) ? $school->zipcode: $request->school_zipcode,
        ];

        $school->update($data);
        return redirect()->route('schools.edit',$school);
    }

    public function getStudents($schoolId, $row=10){
        $students = Student::where('school_id', $schoolId)->paginate($row);
        return StudentResource::collection($students);
    }

    public function editSchool(School $school){
        $countries = Country::all();
        return view('pages.school.edit',compact('school','countries'));
    }

    public function get(School $school){
        if ($school == null)
            return redirect()->route('schools.index')->with(['warning' => 'School not found']);
        $students = Student::where('school_id', $school->id)->paginate(10);
        return view('pages.school.show',compact('school','students'));
    }

    public function delete($schoolId){
        $school = School::find($schoolId);
        if ($school == null)
            return response()->json(['status'=>false, 'message'=>'School Id '.$schoolId.' not found'], 404);
        //TODO delete all SchoolAdmin
        $schoolAdmin = SchoolAdmin::where('school_id', $schoolId);
        $schoolAdminUserId = $schoolAdmin->pluck('user_id');
        $schoolAdmin->delete();
        //TODO delete all student.
        $students = Student::where('school_id', $schoolId);
        if ($students !=null){
            $studentUserIds = $students->pluck('user_id');
            $students->delete();
        }
        //delete students as users
        if ($studentUserIds !=null)
        User::whereIn('id', $studentUserIds)->delete();
        //TODO delete all SchoolAdmin user
        if ($schoolAdminUserId !=null)
            User::whereIn('id', $schoolAdminUserId)->delete();
        $school->delete();
        return redirect()->route('schools.index');
    }
}
