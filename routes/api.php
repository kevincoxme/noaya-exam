<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['namespace' => 'Api\v1', 'middleware' => 'customapi', 'prefix' => 'v1'], function () {

    Route::group(['prefix' => 'company'], function () {

        Route::post('/store', [
            'as' => 'api_company_store',
            'uses' => 'CompanyController@store'
        ]);

        Route::get('/get/all', [
            'as' => 'api_company_get_all',
            'uses' => 'CompanyController@all'
        ]);

        Route::delete('/delete/{id}', [
                'as' => 'api_company_delete',
                'uses' => 'CompanyController@delete'
            ]);

        Route::group(['prefix' => 'employee'], function () {
            Route::post('/store', [
                'as' => 'api_company_employee_store',
                'uses' => 'CompanyController@storeEmployee'
            ]);

            Route::get('/get/all/{id}', [
                'as' => 'api_company__employee_get_all',
                'uses' => 'CompanyController@allEmployee'
            ]);

            Route::delete('/delete/{id}', [
                'as' => 'api_company__employee_delete',
                'uses' => 'CompanyController@deleteEmployee'
            ]);
        });

    });
});
