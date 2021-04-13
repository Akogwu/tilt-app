<?php

$router->group(['prefix' => 'groups'], function () use ($router) {
    $router->get('/', [\App\Http\Controllers\GroupController::class,'getAll']);
    $router->get('/{groupId}', [\App\Http\Controllers\GroupController::class,'getSingle']);
    $router->get('{groupId}/sections', [\App\Http\Controllers\GroupController::class,'getSection']);

    $router->group(['middleware' => 'admin'], function () use ($router) {
        $router->post('/', [\App\Http\Controllers\GroupController::class,'create']);
        $router->put('/{groupId}', [\App\Http\Controllers\GroupController::class,'update']);
        $router->delete('/{groupId}',  [\App\Http\Controllers\GroupController::class,'delete']);
    });
});
