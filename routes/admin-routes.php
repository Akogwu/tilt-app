<?php

Route::middleware(['auth:sanctum', 'verified','admin'])->get('/dashboard',[\App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');

$router->group(['prefix' => 'admin',  'middleware' => ['auth','admin']], function () use ($router) {

    $router->get('/transactions', [\App\Http\Controllers\Admin\AdminController::class,'getTransaction'])->name('admin.transaction');
    $router->get('/private-learners', [\App\Http\Controllers\Admin\AdminController::class,'getAllPrivateLearner'])->name('admin.private-learner');
    $router->get('/admin-accounts', [\App\Http\Controllers\Admin\AdminController::class,'getAllAdmin'])->name('admin.account');

});

$router->group(['prefix' => 'settings',  'middleware' => ['auth','admin']], function () use ($router) {

    $router->get('/', [\App\Http\Controllers\SettingsController::class,'getAll'])->name('setting.get-all');
    $router->post('/', [\App\Http\Controllers\SettingsController::class,'update'])->name('setting.update');
});

$router->group(['prefix' => 'school-management',  'middleware' => ['auth','admin']], function () use ($router) {
    //$router->group(['middleware' => 'admin'], function () use ($router){

    $router->get('/schools', [\App\Http\Controllers\Admin\AdminController::class,'getAllSchool'])->name('schools.index');
    $router->get('/schools/{school}', [\App\Http\Controllers\SchoolController::class,'editSchool'])->name('schools.edit');
    $router->get('/schools/{school}/single', [\App\Http\Controllers\SchoolController::class,'get'])->name('schools.show.school');
    $router->delete('/schools/{schoolId}', [\App\Http\Controllers\SchoolController::class,'delete'])->name('school-delete');
    $router->put('/schools/{schoolId}', [\App\Http\Controllers\SchoolController::class,'updateSchool'])->name('schools.update');
    //admin manage student
    Route::post('/request-delete/{studentId}', [\App\Http\Controllers\SchoolAdminController::class,'requestDelete']);


});
