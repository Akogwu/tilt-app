<?php

$router->group(['prefix' => 'groups'], function () use ($router) {
    $router->get('/', [\App\Http\Controllers\GroupController::class,'getAll']);
    $router->get('/{groupId}', 'GroupController@getSingle');
    $router->get('{groupId}/sections', 'GroupController@getSection');

    $router->group(['middleware' => 'admin'], function () use ($router) {
        $router->post('/', 'GroupController@create');
        $router->put('/{groupId}', 'GroupController@update');
        $router->delete('/{groupId}', 'GroupController@delete');
    });
});
