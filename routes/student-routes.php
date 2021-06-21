<?php
$router->group(['prefix' => 'students'], function () use ($router) {

    $router->get('/{userId}', [\App\Http\Controllers\StudentController::class,'getSingle']);
});
