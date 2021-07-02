<?php
//school admin
Route::group(['prefix' => 'school-admin', 'middleware' => ['auth','school_admin']], function () {
    Route::get('/dashboard', [\App\Http\Controllers\SchoolAdminController::class,'dashboard'])->name('school.admin.dashboard');
    Route::get('/transactions', [\App\Http\Controllers\SchoolAdminController::class,'getTransaction'])->name('school.admin.transaction');
    Route::get('/students', [\App\Http\Controllers\SchoolAdminController::class,'getStudents'])->name('school.admin.student');
    Route::put('/students/{userId}', [\App\Http\Controllers\StudentController::class,'updateProfile'])->name('school-admin.updateStudent');
    Route::post('/request-delete/{studentId}', [\App\Http\Controllers\SchoolAdminController::class,'requestDelete']);
    Route::get('/students/{studentId}', [\App\Http\Controllers\StudentController::class,'getSingleStudent'])->name('school-admin.getStudent');
});

