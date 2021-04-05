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

Route::get('/profile',function (){
    return view('pages.profile');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['prefix'=>'admin', 'middleware' => ['auth:sanctum','verified']],function (){
    Route::get('questionnaire',[\App\Http\Controllers\QuestionnaireController::class,'index'])->name('questionnaire');
});

