<?php
$router->group(['prefix' => 'subscriptions'], function () use ($router) {
    //$router->group(['prefix' => 'subscriptions', 'middleware'=>['auth','admin']], function () use ($router) {

    $router->get('/', [\App\Http\Controllers\SubscriptionController::class,'getAll']);
    $router->post('/', [\App\Http\Controllers\SubscriptionController::class,'create']);
});
