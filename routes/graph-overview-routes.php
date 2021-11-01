<?php
$router->group(['prefix' => 'graph-overviews','middleware' => 'admin'], function () use ($router) {
    $router->get('/', [\App\Http\Controllers\GraphOverviewController::class,'getOverview']);
    $router->post('/', [\App\Http\Controllers\GraphOverviewController::class,'createUpdate']);
    $router->delete('/{id}', [\App\Http\Controllers\GraphOverviewController::class,'delete']);

});
