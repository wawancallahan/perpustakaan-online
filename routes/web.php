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
    return redirect()->route('login');
});

Auth::routes();

Route::get('logout', 'Auth\LoginController@logout');

Route::group(['middleware' => 'role:admin|petugas', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
    Route::resource('book', 'BookController');
    Route::resource('user', 'UserController');
    Route::resource('siswa', 'SiswaController');
    Route::patch('siswa/{id}/active', 'SiswaController@active')->name('siswa.active');
    Route::patch('siswa/{id}/unactive', 'SiswaController@unactive')->name('siswa.unactive');
    Route::resource('config', 'ConfigController')->only(['index', 'edit', 'update']);

    Route::group(['prefix' => 'transaction', 'as' => 'transaction.'], function () {
        Route::get('', 'TransactionController@index')->name('index');
        Route::patch('{id}/return-book', 'TransactionController@returnBook')->name('return-book');
    });
});
