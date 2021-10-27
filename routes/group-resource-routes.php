<?php

$router->group(['prefix' => 'group-resources'], function () use ($router) {
    $router->get('/', [\App\Http\Controllers\GroupResourceController::class,'getAll']);
    $router->get('/{groupResourceId}', [\App\Http\Controllers\GroupResourceController::class,'getSingle']);
    $router->get('/group/{groupId}', [\App\Http\Controllers\GroupResourceController::class,'getSection']);

    $router->group(['middleware' => 'admin'], function () use ($router) {
        $router->post('/', [\App\Http\Controllers\GroupResourceController::class,'create']);
        $router->put('/{groupId}', [\App\Http\Controllers\GroupResourceController::class,'update']);
        $router->delete('/{groupId}',  [\App\Http\Controllers\GroupResourceController::class,'delete']);
    });
});
