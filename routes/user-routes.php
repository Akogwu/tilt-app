<?php
Route::group(['prefix' => 'user-management', 'middleware' => 'auth'], function () {
    Route::post('/update/private-learner/{userId}', [\App\Http\Controllers\UserController::class,'updateProfile'])
        ->name('update.privateLearner');
});
