<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::resource('course',[App\Http\Controllers\CoursesController::class])->middleware('auth');
Route::group(['middleware' => 'auth'], function() {

    //below resource route was not working it was giving blank page
 //   Route::resource('/series', 'App\Http\Controllers\SeriesController');
    //here I am using post for the series post/add because only this worked here
    //for the remaining crud actions I have declated their routes in the api and declared the controller 
    //in the api for them as it those action were not working from here
    Route::post('/companies','App\Http\Controllers\CompanyController@store');



           //Route for employees store action 
   Route::post('/employees','App\Http\Controllers\EmployeeController@store');

  });

  //added this route for the not found url issue 
Route::get('/{any}', [App\Http\Controllers\HomeController::class, 'index'])->where('any', '.*');