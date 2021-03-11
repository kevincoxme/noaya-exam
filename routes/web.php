<?php

use App\Company;
use App\Mail\UsersRegistered;
use App\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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
    Session::put('custom_token', 'noaya-test');
    return view('index');
});

Route::get('/employee/{id}', function ($id) {
    $company = Company::find($id);
    return view('employee', compact('company'));
})->name('employee');

Route::get('/employee/preview/{id}', function ($id) {
    $user = User::find($id);
    return new UsersRegistered($user);
})->name('preview');

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

//Access only by authenticated user
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/home', 'HomeController@update')->name('home_update_logo');
});
