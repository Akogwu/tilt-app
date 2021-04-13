<?php
//TODO change test to tests
/*$router->group(['prefix' => 'test'], function () use ($router) {
    $router->get('/{sessionId}/answers', 'TakeTestController@getAllSessionAnswers');
    //Test Result
    $router->get('/result/{sessionId}/summary', 'TestResultController@getTestResultSummary');
    //My tests
});*/
Route::group(['prefix'=>'test'],function (){
    Route::post('/new-session',[\App\Http\Controllers\TakeTestController::class,'createSession']);
    Route::get('/get-questions',[\App\Http\Controllers\TakeTestController::class,'getAllQuestions']);
    Route::post('/submit',[\App\Http\Controllers\TakeTestController::class,'submitTest']);
    Route::get('/{sessionId}/answers',[\App\Http\Controllers\TakeTestController::class,'getAllSessionAnswers']);
});
Route::group(['prefix' => 'tests', 'middleware'=>'auth'], function () {
        //get detail result
    Route::post('/results/{sessionId}',[\App\Http\Controllers\TestResultController::class,'getTestResult']);
    //Route::post('/{userId}',[\App\Http\Controllers\TestResultController::class,'getMyTestResults']);
    Route::post('details/{userId}',[\App\Http\Controllers\TestResultController::class,'getTestDetails']);
    });

