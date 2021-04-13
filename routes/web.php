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

Route::group(['middleware'=>'auth'], function (){
    Route::get('/profile',[\App\Http\Controllers\ProfileController::class,'index'])->name('user.profile');

});
//auth

//Country endpoints
$router->group(['prefix' => 'countries'], function () use ($router) {
    $router->get('/', [\App\Http\Controllers\CountryController::class,'getAll']);
    $router->get('/{countryId}/states', [\App\Http\Controllers\CountryController::class,'getState'])->name('country.states');
});

Route::middleware(['auth:sanctum', 'verified','admin'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['prefix'=>'admin', 'middleware' => ['auth:sanctum','verified']],function (){
    Route::get('questionnaire',[\App\Http\Controllers\QuestionnaireController::class,'index'])->name('questionnaire');
});

//school admin
Route::group(['prefix' => 'school-admin', 'middleware' => ['auth','school_admin']], function () {
    Route::get('/dashboard', [\App\Http\Controllers\SchoolAdminController::class,'dashboard'])->name('school.admin.dashboard');
    Route::get('/request-delete/{studentId}', [\App\Http\Controllers\SchoolAdminController::class,'requestDelete']);
});


Route::get('logout',function (){
    \Illuminate\Support\Facades\Auth::logout();
    return redirect('/');
});

require_once 'test-routes.php';
require_once 'group-routes.php';
require_once 'questionnaire-routes.php';
require_once 'section-routes.php';
require_once 'subscription-routes.php';
require_once 'admin-routes.php';
require_once 'school-routes.php';
