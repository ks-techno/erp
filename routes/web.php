<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Setting\CountryController;
use App\Http\Controllers\Setting\RegionController;
use App\Http\Controllers\Setting\CityController;
use App\Http\Controllers\Setting\CompanyController;
use App\Http\Controllers\Setting\ProjectController;
use App\Http\Controllers\Setting\DepartmentController;
use App\Http\Controllers\Setting\StaffController;
use App\Http\Controllers\Setting\ProfileController;

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
Route::prefix('password')->name('password.')->group(function () {
    Route::get('request-email', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('show_form');
    Route::post('email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('email');
    Route::get('reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('forgetPassword');
    Route::post('reset', [ResetPasswordController::class, 'reset'])->name('update');

});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::prefix('profile')->name('profile.')->controller(ProfileController::class)->group(function () {
        Route::get('edit', 'edit')->name('edit');
        Route::post('update','update')->name('update');
    });
    Route::prefix('setting')->name('setting.')->group(function () {
        Route::prefix('country')->resource('country', CountryController::class);
        Route::prefix('region')->resource('region', RegionController::class);
        Route::prefix('region')->name('region.')->controller(RegionController::class)->group(function(){
            Route::post('get-regions-by-country', 'getRegionsByCountry')->name('getRegionsByCountry');
        });
        Route::prefix('city')->resource('city', CityController::class);
        Route::prefix('city')->name('city.')->controller(CityController::class)->group(function(){
            Route::post('get-city-by-region', 'getCityByRegion')->name('getCityByRegion');
        });
        Route::prefix('company')->resource('company', CompanyController::class);
        Route::prefix('project')->resource('project', ProjectController::class);
        Route::prefix('department')->resource('department', DepartmentController::class);
        Route::prefix('staff')->resource('staff', StaffController::class);
    });

});
