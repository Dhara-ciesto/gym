<?php

use Illuminate\Http\Request;

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
Route::any('sentoptp', 'APIController@sendotp');
Route::any('otpverify', 'APIController@otpverify');
Route::get('getcompanyinfo', 'APIController@getcompanyinfo');

Route::group(['middleware' => ['applogin']], function () {
    Route::get('getmemberworkout/{id}', 'APIController@getmemberworkout');
    Route::get('getmemberdietplan/{id}', 'APIController@getmemberdietplan');
    Route::get('getpackages/{id}', 'APIController@getpackages');
    Route::get('getprofile/{id}', 'APIController@getprofile');
    Route::get('getmeasurements/{id}', 'APIController@getmeasurements');
    Route::post('postquestion/{id}', 'APIController@postquestion');
});
