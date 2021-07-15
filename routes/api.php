<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\EmployeeController;


use Symfony\Component\HttpKernel\Profiler\Profile;





/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function()
{
   // Route::apiResource('series', App\Http\Controllers\Api\SeriesController::class);

   //crud routes for series are declred here below
   //becuse i tried to make the crud all routes from simple controller and web.php rotues
   //but only post route was working so helplessly i declared the remaining routes here and declared a controller for it
   //in the api directory
    Route::get('/companies', 'App\Http\Controllers\Api\CompanyController@index');
    Route::put('/companies/{id}', 'App\Http\Controllers\Api\CompanyController@update');
    Route::delete('/companies/{id}', 'App\Http\Controllers\Api\CompanyController@destroy');


    Route::get('/employees', 'App\Http\Controllers\Api\EmployeeController@index');
    Route::put('/employees/{id}', 'App\Http\Controllers\Api\EmployeeController@update');
    Route::delete('/employees/{id}', 'App\Http\Controllers\Api\EmployeeController@destroy');
     
 
});
