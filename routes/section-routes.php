<?php

$router->group(['prefix' => 'sections'], function () use ($router) {
    //$router->group(['middleware' => 'admin'], function () use ($router) {
        $router->post('/', [\App\Http\Controllers\SectionController::class,'create']);
        $router->put('/{sectionId}', [\App\Http\Controllers\SectionController::class,'update']);
        $router->delete('/{sectionId}', [\App\Http\Controllers\SectionController::class,'delete']);
    //});
    $router->get('/', [\App\Http\Controllers\SectionController::class,'getAll']);
    $router->get('/{id}', [\App\Http\Controllers\SectionController::class,'getSingle']);
    //questionnaires
    $router->get('/{sectionId}/questionnaires', [\App\Http\Controllers\SectionController::class,'getQuestionnaires']);
});
