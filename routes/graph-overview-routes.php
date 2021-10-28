<?php
$router->group(['prefix' => 'graph-overviews','middleware' => 'admin'], function () use ($router) {
    $router->get('/', [\App\Http\Controllers\GraphOverviewCOntroller::class,'getOverview']);
    $router->post('/', [\App\Http\Controllers\GraphOverviewCOntroller::class,'createUpdate']);
    $router->delete('/{id}', [\App\Http\Controllers\GraphOverviewCOntroller::class,'delete']);

});
