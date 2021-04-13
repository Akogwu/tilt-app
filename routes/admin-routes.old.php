<?php
 $router->group(['prefix' => 'admin', 'middleware' => ['auth'] ], function () use ($router) {
     $router->get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class,'dashboard']);
     $router->get('/settings', [\App\Http\Controllers\SettingsController::class,'getAll']);
     $router->post('/settings', [\App\Http\Controllers\SettingsController::class,'update']);
});
   $router->group(['prefix' => 'user-management',  'middleware' => 'auth'], function () use ($router) {
       //
       $router->group(['middleware' => 'admin'], function () use ($router){
           $router->get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class,'userManagementDashboard']);
           $router->get('/admins', [\App\Http\Controllers\Admin\AdminController::class,'getAllAdmin']);
           $router->get('/private-learners', [\App\Http\Controllers\Admin\AdminController::class,'getAllPrivateLearner']);
           //$router->get('/schools', 'Admin\AdminController@getAllSchool');
           $router->get('/users', [\App\Http\Controllers\UserController::class,'getUsers']);
           $router->get('/students', [\App\Http\Controllers\UserController::class,'getAllStudent']);
           //Activate and deactivate Account
           $router->put('/users/{userId}/activate', [\App\Http\Controllers\UserController::class,'activateUser']);
           $router->put('/users/{userId}/deactivate', 'UserController@deactivateUser');
       });
       //student
       $router->put('/students/{userId}', [\App\Http\Controllers\StudentController::class,'updateProfile']);

       $router->get('/school-admin/{schoolAdminId}', [\App\Http\Controllers\SchoolAdminController::class,'getSchoolAdmin']);
       $router->get('/users/{userId}', [\App\Http\Controllers\UserController::class,'getSingleUser']);
       $router->put('/users/{userId}', [\App\Http\Controllers\UserController::class,'updateProfile']);
       $router->delete('/users/{userId}', [\App\Http\Controllers\UserController::class,'deleteProfile']);


});
//school management
$router->group(['prefix' => 'school-management','middleware' => ['auth'] ], function () use ($router) {
    $router->get('/schools/{schoolId}', [\App\Http\Controllers\SchoolController::class,'get']);
    $router->put('/schools/{schoolId}', [\App\Http\Controllers\SchoolController::class,'updateSchool']);
    //$router->get('/schools/{schoolId}/students', 'SchoolController@getStudents');
    $router->get('/schools/{schoolId}/students', [\App\Http\Controllers\SchoolController::class,'getStudents']);
    $router->get('/get-request-delete', [\App\Http\Controllers\StudentController::class,'getAllRequestDelete']);
    $router->group(['middleware' => 'admin'], function () use ($router){
        $router->get('/schools', [\App\Http\Controllers\Admin\AdminController::class,'getAllSchool'])->name('schools.index');

        $router->delete('/schools/{schoolId}', [\App\Http\Controllers\SchoolController::class,'delete']);
        //delete
        $router->post('/delete-students', [\App\Http\Controllers\StudentController::class,'delete']);
    });
});
