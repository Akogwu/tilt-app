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
    Route::get('/result/{sessionId}/summary', [\App\Http\Controllers\TestResultController::class,'getTestResultSummary'])->name('result.summary');
    //mockdata
//    Route::get('/mock-result', [\App\Http\Controllers\TestResultController::class,'mockResult'])->name('result.summary');

});
Route::group(['prefix' => 'tests', 'middleware'=>'auth'], function () {
        //get detail result
    Route::get('/results/{sessionId}',[\App\Http\Controllers\TestResultController::class,'getTestResult'])->name('result.getResult');
    Route::post('/{userId}',[\App\Http\Controllers\TestResultController::class,'getMyTestResults']);
    Route::post('details/{userId}',[\App\Http\Controllers\TestResultController::class,'getTestDetails']);
});

//$router->group(['prefix' => 'tests'], function () use ($router) {
//    $router->group(['middleware'=>'auth'], function () use ($router) {
//        //get detail result
//        $router->get('/results/{sessionId}', 'TestResultController@getTestResult');
//        $router->get('/{userId}', 'TestResultController@getMyTestResults');
//        $router->get('details/{userId}', 'TestResultController@getTestDetails');
//    });
//    $router->get('/results/{sessionId}/download', 'XTestController@downloadResult');
//});
