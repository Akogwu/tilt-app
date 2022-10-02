<?php
$router->group(['prefix' => 'transactions'], function () use ($router) {
    $router->post('/webhook', [\App\Http\Controllers\TransactionController::class,'callBackHook']);
    //admin


    $router->group(['middleware'=>'auth'], function () use ($router) {
        //school admin
        $router->get('/schools/{schoolId}', [\App\Http\Controllers\TransactionController::class,'school']);
        $router->get('/users/{userId}', [\App\Http\Controllers\TransactionController::class,'user']);

        $router->get('/result/{sessionId}', [\App\Http\Controllers\TransactionController::class,'makePayment'])->name('result.payment');
        $router->get('/school-capacity/{school_id}', [\App\Http\Controllers\TransactionController::class,'schoolCapacityPayment'])->name('schoolCapacity.payment');
        //success/ref=12345?trans=829102
        $router->get('/confirm', [\App\Http\Controllers\TransactionController::class, 'confirmPayment'])
            ->middleware('prevent-back-history')
            ->name('transactions.confirm');
    });
});
