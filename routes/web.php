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

Route::get('', function () {
    return redirect()->route('login');
});

Route::get('logout', 'Auth\LoginController@logout');

Route::group(['middleware' => 'role:admin|petugas', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
    Route::resource('book', 'BookController');
    Route::resource('siswa', 'SiswaController');
    Route::patch('siswa/{id}/active', 'SiswaController@active')->name('siswa.active');
    Route::patch('siswa/{id}/unactive', 'SiswaController@unactive')->name('siswa.unactive');

    Route::group(['middleware' => 'role:admin'], function () {
        Route::resource('config', 'ConfigController')->only(['index', 'edit', 'update']);
        Route::resource('user', 'UserController');
    });

    Route::group(['prefix' => 'transaction', 'as' => 'transaction.'], function () {
        Route::get('', 'TransactionController@index')->name('index');
        Route::patch('{id}/return-book', 'TransactionController@returnBook')->name('return-book');
    });
});

Route::group(['middleware' => 'role:siswa', 'prefix' => 'siswa', 'as' => 'siswa.'], function () {
    Route::get('/', function () {
        return redirect()->route('siswa.dashboard');
    });

    Route::get('dashboard', 'Siswa\SiswaController@dashboard')->name('dashboard');

    Route::group(['prefix' => 'book', 'as' => 'book.'], function () {
        Route::get('book', 'Siswa\BookController@index')->name('index');
        Route::get('book/{id}/borrow', 'Siswa\BookController@borrowShow')->name('borrow.show');
        Route::post('book/{id}/borrow', 'Siswa\BookController@borrowStore')->name('borrow.store');
    });
});

Route::group(['middleware' => 'role:headmaster', 'prefix' => 'headmaster', 'as' => 'headmaster.'], function () {
    Route::get('/', function () {
        return redirect()->route('headmaster.dashboard');
    });

    Route::get('dashboard', 'Headmaster\HeadmasterController@dashboard')->name('dashboard');

    Route::group(['prefix' => 'transaction', 'as' => 'transaction.'], function () {
        Route::get('', 'Headmaster\TransactionController@index')->name('index');
    });
});
