<?php
//TODO change test to tests

Route::group(['prefix'=>'test'],function (){
    Route::post('/new-session',[\App\Http\Controllers\TakeTestController::class,'createSession'])->name('test.new-session');
    Route::get('/get-questions',[\App\Http\Controllers\TakeTestController::class,'getAllQuestions']);
    Route::post('/submit',[\App\Http\Controllers\TakeTestController::class,'submitTest']);
    Route::get('/{sessionId}/answers',[\App\Http\Controllers\TakeTestController::class,'getAllSessionAnswers']);
    Route::get('/result/{sessionId}/summary', [\App\Http\Controllers\TestResultController::class,'getTestResultSummary'])->name('result.summary');
    Route::get("/result-view/{sessionId}", [\App\Http\Controllers\TestResultController::class,'viewTestResult'])->name('result.view');
});
Route::group(['prefix' => 'tests', 'middleware'=>'auth'], function () {
        //get detail result
    Route::get('/results/{sessionId}',[\App\Http\Controllers\TestResultController::class,'viewTestResult'])->name('result.getResult');
    Route::post('/{userId}',[\App\Http\Controllers\TestResultController::class,'getMyTestResults']);
    Route::post('details/{userId}',[\App\Http\Controllers\TestResultController::class,'getTestDetails']);
});
