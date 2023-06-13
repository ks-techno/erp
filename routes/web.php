<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Accounts\ChartOfAccountTreeController;
use App\Http\Controllers\Accounts\ChartOfAccountController;
use App\Http\Controllers\Accounts\BankPaymentController;
use App\Http\Controllers\Accounts\LedgerController;
use App\Http\Controllers\Accounts\BankReceiveController;
use App\Http\Controllers\Accounts\CashPaymentController;
use App\Http\Controllers\Accounts\CashReceiveController;
use App\Http\Controllers\Accounts\JournalController;
use App\Http\Controllers\Setting\CountryController;
use App\Http\Controllers\Setting\RegionController;
use App\Http\Controllers\Setting\CityController;
use App\Http\Controllers\Setting\CompanyController;
use App\Http\Controllers\Setting\ProjectController;
use App\Http\Controllers\Setting\DepartmentController;
use App\Http\Controllers\Setting\StaffController;
use App\Http\Controllers\Setting\ProfileController;
use App\Http\Controllers\Setting\UserManagementSystemController;
use App\Http\Controllers\Setting\UserController;
use App\Http\Controllers\Purchase\CategoryTypeController;
use App\Http\Controllers\Purchase\CategoryController;
use App\Http\Controllers\Purchase\BrandController;
use App\Http\Controllers\Purchase\ManufacturerController;
use App\Http\Controllers\Purchase\SupplierController;
use App\Http\Controllers\Purchase\InventoryController;
use App\Http\Controllers\Purchase\ProductPropertyController;
use App\Http\Controllers\Purchase\BuyableTypeController;
use App\Http\Controllers\Purchase\ProductVariationController;
use App\Http\Controllers\Purchase\PurchaseDemandController;
use App\Http\Controllers\Sale\DealerController;
use App\Http\Controllers\Sale\CustomerController;
use App\Http\Controllers\Sale\SaleInvoiceController;
use App\Http\Controllers\Sale\BookingTransferController;
use App\Http\Controllers\Sale\OpenFileController;
use App\Http\Controllers\Sale\RefundFileController;
use App\Http\Controllers\Purchase\BookedPropertyController;
use App\Http\Controllers\Sale\ChallanFormController;
use App\Http\Controllers\Accounts\SubmittedChallanController;

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
    Route::get('/project-list', [HomeController::class,'projectList'])->name('projectList');
    Route::post('/store-default-project', [HomeController::class,'defaultProjectStore'])->name('defaultProjectStore');
    Route::group(['middleware' => ['checkProject']], function () {

        Route::get('/home', [HomeController::class, 'index'])->name('home');

        Route::prefix('profile')->name('profile.')->controller(ProfileController::class)->group(function () {
            Route::get('edit', 'edit')->name('edit');
            Route::post('update','update')->name('update');
        });
        Route::prefix('help')->name('help.')->group(function () {
            Route::get('chart/{str?}', [HelpController::class, 'chart'])->name('chart');
            Route::get('customer/{str?}', [HelpController::class, 'customer'])->name('customer');
            Route::get('oldCustomerHelp/{str?}', [HelpController::class, 'oldCustomerHelp'])->name('oldCustomerHelp');
            Route::get('property-product/{str?}', [HelpController::class, 'propertyProduct'])->name('propertyProduct');
        });

        Route::prefix('accounts')->name('accounts.')->group(function () {
            //  Route::prefix('chart-of-account-tree')->resource('chart-of-account-tree', ChartOfAccountTreeController::class);
            Route::prefix('chart-of-account-tree')->name('chart-of-account-tree.')->controller(ChartOfAccountTreeController::class)->group(function(){
                Route::get('/', 'index')->name('index');
                Route::get('get-chart-of-account-tree', 'getChartOfAccountTree')->name('getChartOfAccountTree');
            });
            Route::prefix('chart-of-account')->resource('chart-of-account', ChartOfAccountController::class);
            Route::prefix('chart-of-account')->name('chart-of-account.')->controller(ChartOfAccountController::class)->group(function(){
                Route::post('get-parent-coa', 'getParentCoaList')->name('getParentCoaList');
                Route::post('get-code-by-parent-account', 'getChildCodeByParentAccount')->name('getChildCodeByParentAccount');

            });
            Route::prefix('bank-payment')->name('bank-payment.')->controller(BankPaymentController::class)->group(function(){
                Route::get('print/{id}', 'printView')->name('print');
                Route::get('revert-list', 'revertList')->name('revertList');
                Route::post('revert/{id}', 'revert')->name('revert');
            });
            Route::prefix('bank-payment')->resource('bank-payment', BankPaymentController::class);
            Route::prefix('ledgers')->name('ledgers.')->controller(LedgerController::class)->group(function(){
                Route::get('print/{id}', 'printView')->name('print');
                Route::get('revert-list', 'revertList')->name('revertList');
                Route::post('revert/{id}', 'revert')->name('revert');
            });
            Route::prefix('ledgers')->resource('ledgers', LedgerController::class);

            Route::prefix('bank-receive')->name('bank-receive.')->controller(BankReceiveController::class)->group(function(){
                Route::get('print/{id}', 'printView')->name('print');
                Route::get('revert-list', 'revertList')->name('revertList');
                Route::post('revert/{id}', 'revert')->name('revert');
            });
            Route::prefix('bank-receive')->resource('bank-receive', BankReceiveController::class);

            Route::prefix('cash-payment')->name('cash-payment.')->controller(CashPaymentController::class)->group(function(){
                Route::get('print/{id}', 'printView')->name('print');
                Route::get('revert-list', 'revertList')->name('revertList');
                Route::post('revert/{id}', 'revert')->name('revert');
            });
            Route::prefix('cash-payment')->resource('cash-payment', CashPaymentController::class);

            Route::prefix('cash-receive')->name('cash-receive.')->controller(CashReceiveController::class)->group(function(){
                Route::get('print/{id}', 'printView')->name('print');
                Route::get('revert-list', 'revertList')->name('revertList');
                Route::post('revert/{id}', 'revert')->name('revert');
            });
            Route::prefix('cash-receive')->resource('cash-receive', CashReceiveController::class);

            Route::prefix('journal')->name('journal.')->controller(JournalController::class)->group(function(){
                Route::get('print/{id}', 'printView')->name('print');
                Route::get('revert-list', 'revertList')->name('revertList');
                Route::post('revert/{id}', 'revert')->name('revert');
            });
            Route::prefix('journal')->resource('journal', JournalController::class);

            Route::prefix('submitted-challan')->name('submitted-challan.')->controller(SubmittedChallanController::class)->group(function(){
                Route::get('print/{id}', 'printView')->name('print');
                Route::get('revert-list', 'revertList')->name('revertList');
                Route::post('revert/{id}', 'revert')->name('revert');
                Route::get('voucherCreate/{id}', 'voucherCreate')->name('voucherCreate');
                Route::post('storeVoucher/{id}', 'storeVoucher')->name('storeVoucher');
            });
            Route::prefix('submitted-challan')->resource('submitted-challan', SubmittedChallanController::class);
        });
            
        Route::prefix('company')->resource('company', CompanyController::class);
        Route::prefix('project')->resource('project', ProjectController::class);
        Route::prefix('department')->resource('department', DepartmentController::class);
        Route::prefix('staff')->resource('staff', StaffController::class);

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
           
            Route::prefix('user')->resource('user', UserController::class);
                Route::prefix('user-management')->name('user-management.')->group(function () {
                Route::get('form/{id?}', [UserManagementSystemController::class, 'create'])->name('create');
                Route::post('form/{id?}', [UserManagementSystemController::class, 'store'])->name('store');
            });

        });

        Route::prefix('product-property')->resource('product-property', ProductPropertyController::class);
        Route::get('exportPDF', [LedgerController::class, 'exportPDF'])->name('exportPDF');
        Route::get('exportExcel', [LedgerController::class, 'exportExcel'])->name('exportExcel');
        Route::get('product-property-print', [ProductPropertyController::class, 'printView'])->name('product-property-print');
        Route::get('refund-file-print', [RefundFileController::class, 'printResults'])->name('refund-file-print');
        Route::get('booked-proprty-print', [BookedPropertyController::class, 'printResults'])->name('booked-proprty-print');
        Route::get('transfer-proprty-print', [BookingTransferController::class, 'printResults'])->name('transfer-proprty-print');


        Route::prefix('product-property')->name('product-property.')->controller(ProductPropertyController::class)->group(function(){
            Route::post('get-seller-list', 'getSellerList')->name('getSellerList');
            Route::post('get-product-detail', 'getProductDetail')->name('getProductDetail');
        });
        Route::prefix('booked-property')->resource('booked-property', BookedPropertyController::class);
        Route::prefix('booked-property')->name('booked-property.')->controller(BookedPropertyController::class)->group(function(){
            Route::post('get-seller-list', 'getSellerList')->name('getSellerList');
            Route::post('get-product-detail', 'getProductDetail')->name('getProductDetail');
            Route::get('print/{id}', 'printView')->name('print');
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
            Route::prefix('inventory')->resource('inventory', InventoryController::class);
            Route::prefix('purchase-demand')->resource('purchase-demand', PurchaseDemandController::class);
          
            Route::prefix('property-type')->resource('property-type', BuyableTypeController::class);
            Route::prefix('product-variation')->resource('product-variation', ProductVariationController::class);
            Route::prefix('product-variation')->name('product-variation.')->controller(ProductVariationController::class)->group(function(){
                Route::post('get-product-variation-by-buyable-type', 'getProductVariations')->name('getProductVariations');
            });
  });
       Route::prefix('customer')->resource('customer', CustomerController::class);

               Route::prefix('sale')->name('sale.')->group(function () {
               Route::prefix('dealer')->resource('dealer', DealerController::class);
               Route::prefix('sale-invoice')->resource('sale-invoice', SaleInvoiceController::class);
               Route::prefix('sale-invoice')->name('sale-invoice.')->controller(SaleInvoiceController::class)->group(function(){
                Route::post('get-seller-list', 'getSellerList')->name('getSellerList');
                Route::post('get-product-detail', 'getProductDetail')->name('getProductDetail');
                Route::get('print/{id}', 'printView')->name('print');
            });
            Route::prefix('challan-form')->resource('challan-form', ChallanFormController::class);
            Route::prefix('challan-form')->name('challan-form.')->controller(ChallanFormController::class)->group(function(){
                Route::post('get-customer-list', 'getCustomerList')->name('getCustomerList');
                Route::post('get-booking-detail', 'getBookingDtl')->name('getBookingDtl');
                Route::get('print/{id}', 'printView')->name('print');
            });
            Route::prefix('open-file')->resource('open-file', OpenFileController::class);
            Route::prefix('open-file')->name('open-file.')->controller(OpenFileController::class)->group(function(){
                Route::post('get-customer-list', 'getCustomerList')->name('getCustomerList');
                Route::post('get-booking-detail', 'getBookingDtl')->name('getBookingDtl');
                Route::get('print/{id}', 'printView')->name('print');
            });
            Route::prefix('refund-file')->resource('refund-file', RefundFileController::class);
            Route::prefix('refund-file')->name('refund-file.')->controller(RefundFileController::class)->group(function(){
                Route::post('get-refund-customer-list', 'getRefundCustomerList')->name('getRefundCustomerList');
                Route::post('get-booking-detail', 'getBookingDtl')->name('getBookingDtl');
                Route::get('print/{id}', 'printView')->name('print');
                Route::get('formprint/{id}', 'formPrint')->name('formprint');
            });
            Route::prefix('booking-transfer')->resource('booking-transfer', BookingTransferController::class);
            Route::prefix('booking-transfer')->name('booking-transfer.')->controller(BookingTransferController::class)->group(function(){
                Route::post('get-customer-list', 'getCustomerList')->name('getCustomerList');
                Route::post('get-refund-customer-list', 'getRefundCustomerList')->name('getRefundCustomerList');
                Route::post('get-booking-detail', 'getBookingDtl')->name('getBookingDtl');
                Route::get('print/{id}', 'printView')->name('print');
            });
        });
    });
});
