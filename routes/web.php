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

Auth::routes();
Route::get('/', 'JobController@index')->name('job.index');

Route::group(['middleware' => ['verified','auth']], function () {
    Route::get('/home', 'JobController@fillForm')->name('home');
    Route::post('update', 'JobController@update')->name('job.store');
    Route::get('/view-detail', 'JobController@detail')->name('view-detail');
});
