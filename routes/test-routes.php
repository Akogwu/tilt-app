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
    Route::get('/submit',[\App\Http\Controllers\TakeTestController::class,'submitTest']);
    Route::get('/{sessionId}/answers',[\App\Http\Controllers\TakeTestController::class,'getAllSessionAnswers']);
});
//$router->group(['prefix' => 'tests'], function () use ($router) {
//    $router->group(['middleware'=>'auth'], function () use ($router) {
//        //get detail result
//    $router->get('/results/{sessionId}', 'TestResultController@getTestResult');
//    $router->get('/{userId}', 'TestResultController@getMyTestResults');
//    $router->get('details/{userId}', 'TestResultController@getTestDetails');
//    });
//    $router->get('/results/{sessionId}/download', 'XTestController@downloadResult');
//});

