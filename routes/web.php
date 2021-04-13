<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('pages.home');
});
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

Route::get('/profile',[\App\Http\Controllers\ProfileController::class,'index'])->name('user.profile');

//Country endpoints
$router->group(['prefix' => 'countries'], function () use ($router) {
    $router->get('/', [\App\Http\Controllers\CountryController::class,'getAll']);
    $router->get('/{countryId}/states', [\App\Http\Controllers\CountryController::class,'getState'])->name('country.states');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['prefix'=>'admin', 'middleware' => ['auth:sanctum','verified']],function (){
    Route::get('questionnaire',[\App\Http\Controllers\QuestionnaireController::class,'index'])->name('questionnaire');
});

require_once 'test-routes.php';
require_once 'group-routes.php';
require_once 'questionnaire-routes.php';
require_once 'section-routes.php';
require_once 'subscription-routes.php';
require_once 'admin-routes.php';
require_once 'school-routes.php';
