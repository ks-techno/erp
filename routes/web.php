<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Setting\CountryController;

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
    if (Auth::check()) {
        return redirect('/home');
    }else {
        return view('auth.login');
    }
});

/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();
Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::prefix('setting')->name('setting.')->group(function () {
        Route::prefix('country')->name('country.')->controller(CountryController::class)->group(function () {
            Route::get('list', 'index')->name('list');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('update/{id}', 'update')->name('update');
            Route::post('delete/{id}', 'destroy')->name('destroy');
        });
    });

});
