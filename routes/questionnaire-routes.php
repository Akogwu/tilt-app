<?php

//Admin routes
$router->group(['prefix' => 'questionnaire'], function () use ($router) {
    $router->get('/{id}', [\App\Http\Controllers\QuestionnaireController::class,'getSingle']);
    //$router->group(['middleware' => 'admin'], function () use ($router) {

    $router->post('/', [\App\Http\Controllers\QuestionnaireController::class,'create']);
    $router->put('/{id}', [\App\Http\Controllers\QuestionnaireController::class,'update']);
    $router->delete('/{id}', [\App\Http\Controllers\QuestionnaireController::class,'delete']);
    $router->post('/weight-points/{questionnaireId}', [\App\Http\Controllers\QuestionnaireController::class,'addWeightPoint']);
    //});
});
