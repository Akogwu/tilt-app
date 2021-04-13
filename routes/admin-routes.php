<?php

$router->group(['prefix' => 'admin', 'middleware' => ['auth'] ], function () use ($router) {
    $router->get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'dashboard']);
});

$router->group(['prefix' => 'school-management',  'middleware' => 'auth'], function () use ($router) {
    //$router->group(['middleware' => 'admin'], function () use ($router){

    $router->get('/schools', [\App\Http\Controllers\Admin\AdminController::class,'getAllSchool'])->name('schools.index');
    $router->get('/schools/{school}', [\App\Http\Controllers\SchoolController::class,'editSchool'])->name('schools.edit');
    $router->get('/schools/{school}/single', [\App\Http\Controllers\SchoolController::class,'get'])->name('schools.show.school');
    $router->delete('/schools/{schoolId}', [\App\Http\Controllers\SchoolController::class,'delete'])->name('school-delete');
    $router->put('/schools/{schoolId}', [\App\Http\Controllers\SchoolController::class,'updateSchool'])->name('schools.update');
    //});

});
