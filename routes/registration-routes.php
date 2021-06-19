<?php
use Illuminate\Support\Facades\Route;

//Route::group(['prefix' => 'schools'],function () {
//    Route::get('/',[\App\Http\Controllers\SchoolAdminController::])->name('schools.index');
//});

//Registrations
$router->group(['prefix' => 'registration'], function () use ($router) {
    $router->post('/admin', [\App\Http\Controllers\RegistrationController::class,'admin']);
    $router->get('/school',[\App\Http\Controllers\RegistrationController::class,'createSchool'])->name('create.school');
    $router->post('/schools', [\App\Http\Controllers\RegistrationController::class,'school'])->name('school.register');
    $router->post('/learner', [\App\Http\Controllers\RegistrationController::class,'privateLeaner']);
    $router->post('/students', [\App\Http\Controllers\RegistrationController::class,'student'])->name('student.register');
});
