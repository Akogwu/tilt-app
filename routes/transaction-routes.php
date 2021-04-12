<?php
$router->group(['prefix' => 'transactions'], function () use ($router) {
    $router->post('/webhook', [\App\Http\Controllers\TransactionController::class,'callBackHook']);
    //admin
    $router->group(['middleware' => 'admin'], function () use ($router) {
        $router->get('/', [\App\Http\Controllers\TransactionController::class,'getAll']);
    });

    $router->group(['middleware'=>'auth'], function () use ($router) {
        //school admin
        $router->get('/schools/{schoolId}', [\App\Http\Controllers\TransactionController::class,'school']);
        $router->get('/users/{userId}', [\App\Http\Controllers\TransactionController::class,'user']);
    });
});
