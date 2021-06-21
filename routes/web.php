<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\PublicController::class,'home']);

Route::get('/about', function () {
    return view('pages.about');
});
Route::get('/contact',function (){
    return view('pages.contact');
})->name('me.contact');

Route::get('/test',function (){
    return view('pages.test');
});
Route::get('/take-test',function (){
    return view('pages.questions');
})->name('questions');

Route::group(['middleware'=>'auth'], function (){
    Route::get('/profile',[\App\Http\Controllers\ProfileController::class,'index'])->name('user.profile');

});
//auth

//Country endpoints
$router->group(['prefix' => 'countries'], function () use ($router) {
    $router->get('/', [\App\Http\Controllers\CountryController::class,'getAll']);
    $router->get('/{countryId}/states', [\App\Http\Controllers\CountryController::class,'getState'])->name('country.states');
});


Route::group(['prefix'=>'admin', 'middleware' => ['auth:sanctum','verified']],function (){
    Route::get('questionnaire',[\App\Http\Controllers\QuestionnaireController::class,'index'])->name('questionnaire');
});


Route::get('/complete',function (){
    return view('pages.results.complete');
});

Route::get('logout',function (){
    \Illuminate\Support\Facades\Auth::logout();
    return redirect('/');
});


// print complete result route
Route::get('/print-result',[\App\Http\Controllers\PDFController::class,'generateResult'])->name('print-result');

require_once 'test-routes.php';
require_once 'group-routes.php';
require_once 'questionnaire-routes.php';
require_once 'section-routes.php';
require_once 'subscription-routes.php';
require_once 'admin-routes.php';
require_once 'registration-routes.php';
require_once 'user-routes.php';
require_once 'school-admin-routes.php';
require_once 'student-routes.php';
