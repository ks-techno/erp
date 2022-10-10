<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Accounts\ChartOfAccountController;
use App\Http\Controllers\Accounts\BankPaymentController;
use App\Http\Controllers\Accounts\BankReceiveController;
use App\Http\Controllers\Accounts\CashPaymentController;
use App\Http\Controllers\Accounts\CashReceiveController;
use App\Http\Controllers\Setting\CountryController;
use App\Http\Controllers\Setting\RegionController;
use App\Http\Controllers\Setting\CityController;
use App\Http\Controllers\Setting\CompanyController;
use App\Http\Controllers\Setting\ProjectController;
use App\Http\Controllers\Setting\DepartmentController;
use App\Http\Controllers\Setting\StaffController;
use App\Http\Controllers\Setting\ProfileController;
use App\Http\Controllers\Setting\UserManagementSystemController;
use App\Http\Controllers\Purchase\CategoryTypeController;
use App\Http\Controllers\Purchase\CategoryController;
use App\Http\Controllers\Purchase\BrandController;
use App\Http\Controllers\Purchase\ManufacturerController;
use App\Http\Controllers\Purchase\SupplierController;
use App\Http\Controllers\Purchase\ProductController;
use App\Http\Controllers\Purchase\ProductPropertyController;
use App\Http\Controllers\Purchase\BuyableTypeController;
use App\Http\Controllers\Purchase\ProductVariationController;
use App\Http\Controllers\Sale\DealerController;
use App\Http\Controllers\Sale\CustomerController;
use App\Http\Controllers\Sale\SaleInvoiceController;

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
    Route::prefix('help')->name('help.')->group(function () {
        Route::get('chart/{str?}', [HelpController::class, 'chart'])->name('chart');
    });

    Route::prefix('accounts')->name('accounts.')->group(function () {
        Route::prefix('chart-of-account')->resource('chart-of-account', ChartOfAccountController::class);
        Route::prefix('chart-of-account')->name('chart-of-account.')->controller(ChartOfAccountController::class)->group(function(){
            Route::post('get-parent-coa', 'getParentCoaList')->name('getParentCoaList');
            Route::post('get-code-by-parent-account', 'getChildCodeByParentAccount')->name('getChildCodeByParentAccount');
        });
        Route::prefix('bank-payment')->resource('bank-payment', BankPaymentController::class);
        Route::prefix('bank-receive')->resource('bank-receive', BankReceiveController::class);
        Route::prefix('cash-payment')->resource('cash-payment', CashPaymentController::class);
        Route::prefix('cash-receive')->resource('cash-receive', CashReceiveController::class);

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

        Route::prefix('user-management')->name('user-management.')->group(function () {
            Route::get('form/{id?}', [UserManagementSystemController::class, 'create'])->name('create');
            Route::post('form/{id?}', [UserManagementSystemController::class, 'store'])->name('store');
        });
    });

    Route::prefix('purchase')->name('purchase.')->group(function () {
        Route::prefix('category_types')->resource('category_types', CategoryTypeController::class);
        Route::prefix('category')->resource('category', CategoryController::class);
        Route::prefix('category')->name('category.')->controller(CategoryController::class)->group(function(){
            Route::post('get-child-by-parent', 'getChildByParentCategory')->name('getChildByParentCategory');
        });
        Route::prefix('brand')->resource('brand', BrandController::class);
        Route::prefix('manufacturer')->resource('manufacturer', ManufacturerController::class);
        Route::prefix('supplier')->resource('supplier', SupplierController::class);
        Route::prefix('product')->resource('product', ProductController::class);
        Route::prefix('product-property')->resource('product-property', ProductPropertyController::class);
        Route::prefix('property-type')->resource('property-type', BuyableTypeController::class);
        Route::prefix('product-variation')->resource('product-variation', ProductVariationController::class);
        Route::prefix('product-variation')->name('product-variation.')->controller(ProductVariationController::class)->group(function(){
            Route::post('get-product-variation-by-buyable-type', 'getProductVariations')->name('getProductVariations');
        });

    });
    Route::prefix('sale')->name('sale.')->group(function () {
        Route::prefix('dealer')->resource('dealer', DealerController::class);
        Route::prefix('customer')->resource('customer', CustomerController::class);
        Route::prefix('sale-invoice')->resource('sale-invoice', SaleInvoiceController::class);
        Route::prefix('sale-invoice')->name('sale-invoice.')->controller(SaleInvoiceController::class)->group(function(){
            Route::post('get-seller-list', 'getSellerList')->name('getSellerList');
        });
    });

});
