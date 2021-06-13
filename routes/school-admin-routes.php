<?php
//school admin
Route::group(['prefix' => 'school-admin', 'middleware' => ['auth','school_admin']], function () {
    Route::get('/dashboard', [\App\Http\Controllers\SchoolAdminController::class,'dashboard'])->name('school.admin.dashboard');
    Route::get('/transactions', [\App\Http\Controllers\SchoolAdminController::class,'getTransaction'])->name('school.admin.transaction');
    Route::get('/students', [\App\Http\Controllers\SchoolAdminController::class,'getStudent'])->name('school.admin.student');
    Route::get('/request-delete/{studentId}', [\App\Http\Controllers\SchoolAdminController::class,'requestDelete']);
});

