<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\CompanyInformationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemArrivalController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseInvoiceController;
use App\Http\Controllers\SaleInvoiceController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SystemRoleController;
use App\Http\Controllers\UnitMeasurementController;
use App\Http\Controllers\WarehouseController;
use App\Models\SaleInvoice;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function (Request $request) {


    if (auth()->check()) {

        $user = auth()->user();

        if ($user->IsActive == 0) {
            auth()->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()->route('login')->with('warning', "Your account is disabled so you can't login!");
        }

        if($user->systemrole->RoleDesc == "admin"){
            return redirect()->route('dashboard');
        }

        return redirect()->route('saleinvoices');
    } else {
        return redirect()->route('login');
    }
});

Route::get('/home',function(){

    if(auth()->check()){
        return view('home');
    }else{
        return redirect()->route('login')->with('warning','you must login to access this page');
    }
   
});



Route::get('/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'postLogin'])->middleware('guest');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('mymiddleware:dashboard')->name('dashboard');

//Report Route 
Route::middleware('mymiddleware:report')->group(function () {

    Route::get('/report/index', function () {
        return view('reports.index');
    });

    Route::get('/customer/reports', [CustomerController::class, 'customerreports']);
    Route::get('/supplier/reports', [SupplierController::class, 'supplierreports']);
    Route::get('/warehouse/reports', [WarehouseController::class, 'warehousereports']);
    Route::get('/category/reports', [ItemCategoryController::class, 'categoryreports']);
    Route::get('/unit/reports', [UnitMeasurementController::class, 'unitmeasurementreports']);
    Route::get('/item/reports', [ItemController::class, 'itemreports']);
    Route::get('/user/reports', [AuthController::class, 'userreports']);
    Route::get('/systemrole/reports', [SystemRoleController::class, 'systemrolereports']);
    Route::get('/salesinvoices/reports', [SaleInvoiceController::class, 'salesinvoicesreports']);
    Route::get('/purchaseinvoices/reports', [PurchaseInvoiceController::class, 'purchaseinvoicesreports']);
});



//Set up Route
Route::middleware('mymiddleware:setup')->group(function () {

    // Company Information route
    Route::prefix('companyinformation')->group(function () {
        Route::get('/index', [CompanyInformationController::class, 'index'])->name('companyinformation');
        Route::get('/add', [CompanyInformationController::class, 'create'])->name('addcompanyinformation');
        Route::post('/add', [CompanyInformationController::class, 'store']);
        Route::get('/edit/{company:CompanyCode}', [CompanyInformationController::class, 'show'])->where('company', '^CI-(\d+)$')->name('companyinformation.edit');
        Route::post('/update/{company:CompanyCode}', [CompanyInformationController::class, 'update'])->where('company', '^CI-(\d+)$')->name('companyinformation.update');
        Route::get('/delete/{company:CompanyCode}', [CompanyInformationController::class, 'destory'])->where('company', '^CI-(\d+)$')->name('companyinformation.delete');
    });

    //customer setup routes
    Route::prefix('customer')->group(function () {
        Route::get('/index', [CustomerController::class, 'index'])->name('customers');
        Route::get('/reports', [CustomerController::class, 'customerreports']);
        Route::get('/add', [CustomerController::class, 'create']);
        Route::post('/add', [CustomerController::class, 'store']);
        Route::get('/edit/{id:CustomerCode}', [CustomerController::class, 'showedit'])->where('id', '^CS-(\d+)$');
        Route::post('/update/{id:CustomerCode}', [CustomerController::class, 'updatecustomer'])->where('id', '^CS-(\d+)$');
        Route::get('/delete/{id:CustomerCode}', [CustomerController::class, 'destory'])->where('id', '^CS-(\d+)$');
    });

    // Supplier setup routes
    Route::prefix('supplier')->group(function () {
        Route::get('/index', [SupplierController::class, 'index'])->name('supplier');
        Route::get('/reports', [SupplierController::class, 'supplierreports']);
        Route::get('/add', [SupplierController::class, 'create'])->name('addsupplier');
        Route::post('/add', [SupplierController::class, 'store']);
        Route::get('/edit/{supplier:SupplierCode}', [SupplierController::class, 'show'])->where('supplier', '^SP-(\d+)$');
        Route::post('/update/{supplier:SupplierCode}', [SupplierController::class, 'update'])->where('supplier', '^SP-(\d+)$');
        Route::get('/delete/{supplier:SupplierCode}', [SupplierController::class, 'destory'])->where('supplier', '^SP-(\d+)$');
    });

    // Warehouse setup routes
    Route::prefix('warehouse')->group(function () {
        Route::get('/index', [WarehouseController::class, 'index'])->name('warehouse');
        Route::get('/reports', [WarehouseController::class, 'warehousereports']);
        Route::get('/add', [WarehouseController::class, 'create'])->name('addwarehouse');
        Route::post('/add', [WarehouseController::class, 'store']);
        Route::get('/edit/{warehouse:WarehouseCode}', [WarehouseController::class, 'show'])->where('warehouse', '^WH-(\d+)$');
        Route::post('/update/{warehouse:WarehouseCode}', [WarehouseController::class, 'update'])->where('warehouse', '^WH-(\d+)$');
        Route::get('/delete/{warehouse:WarehouseCode}', [WarehouseController::class, 'destory'])->where('warehouse', '^WH-(\d+)$');
    });

    //category setup routes
    Route::prefix('category')->group(function () {
        Route::get('/index', [ItemCategoryController::class, 'index'])->name('categories');
        Route::get('/reports', [ItemCategoryController::class, 'categoryreports']);
        Route::get('/add', [ItemCategoryController::class, 'create']);
        Route::post('/add', [ItemCategoryController::class, 'store']);
        Route::get('/edit/{category:ItemCategoryCode}', [ItemCategoryController::class, 'show'])->where('category', '^CT-(\d+)$');
        Route::post('/update/{category:ItemCategoryCode}', [ItemCategoryController::class, 'update'])->where('category', '^CT-(\d+)$');
        Route::get('/delete/{category:ItemCategoryCode}', [ItemCategoryController::class, 'destory'])->where('category', '^CT-(\d+)$');
    });

    //unit setup routes
    Route::prefix('unit')->group(function () {
        Route::get('/index', [UnitMeasurementController::class, 'index'])->name('units');
        Route::get('/reports', [UnitMeasurementController::class, 'unitmeasurementreports']);
        Route::get('/add', [UnitMeasurementController::class, 'create']);
        Route::post('/add', [UnitMeasurementController::class, 'store']);
        Route::get('/edit/{unit:UnitCode}', [UnitMeasurementController::class, 'show']);
        Route::post('/update/{unit:UnitCode}', [UnitMeasurementController::class, 'update']);
        Route::get('/delete/{unit:UnitCode}', [UnitMeasurementController::class, 'destory']);
    });

    // Items Setup routes 
    Route::prefix('item')->group(function () {
        Route::get('/index', [ItemController::class, 'index'])->name('items');
        Route::get('/reports', [ItemController::class, 'itemreports']);
        Route::get('/add', [ItemController::class, 'create']);
        Route::post('/add', [ItemController::class, 'store']);
        Route::get('/edit/{item:ItemCode}', [ItemController::class, 'show'])->where('item', '^SI-(\d+)$');
        Route::post('/update/{item:ItemCode}', [ItemController::class, 'update'])->where('item', '^SI-(\d+)$');
        Route::get('/delete/{item:ItemCode}', [ItemController::class, 'destory'])->where('item', '^SI-(\d+)$');
    });
});

//System Role and User
Route::middleware('mymiddleware:system')->group(function () {
    // System User routes
    Route::prefix('user')->group(function () {
        Route::get('/index', [AuthController::class, 'index'])->name('users');
        Route::get('/add', [AuthController::class, 'create']);
        Route::post('/add', [AuthController::class, 'store']);
        Route::get('/edit/{user:Username}', [AuthController::class, 'show'])->where('user', '[A-z]+');
        Route::post('/update/{user:Username}', [AuthController::class, 'update'])->where('user', '[A-z]+');
        Route::get('/delete/{user:Username}', [AuthController::class, 'destory'])->where('user', '[A-z]+');
        Route::get('/reports', [AuthController::class, 'userreports']);
    });

    // System Role routes
    Route::prefix('systemrole')->group(function () {
        Route::get('/index', [SystemRoleController::class, 'index'])->name('roles');
        Route::get('/add', [SystemRoleController::class, 'create']);
        Route::post('/add', [SystemRoleController::class, 'store']);
        Route::get('/edit/{role:RoleId}', [SystemRoleController::class, 'show'])->where('role', '[\d]');
        Route::post('/update/{role:RoleId}', [SystemRoleController::class, 'update'])->where('role', '[\d]');
        Route::get('/delete/{role:RoleId}', [SystemRoleController::class, 'destory'])->where('role', '[\d]');
        Route::get('/reports', [SystemRoleController::class, 'systemrolereports']);
    });
});

// Sales Invoice routes
Route::prefix('salesinvoices')->middleware('mymiddleware:sales')->group(function () {
    Route::get('/index', [SaleInvoiceController::class, 'index'])->name('saleinvoices');
    Route::get('/add', [SaleInvoiceController::class, 'create'])->name('addsalesinvoice');
    Route::post('/add', [SaleInvoiceController::class, 'store']);
    Route::get('/edit/{saleinvoice:InvoiceNo}', [SaleInvoiceController::class, 'show'])->where('saleinvoice', '^SV-(\d+)$');
    Route::post('/update/{saleinvoice:InvoiceNo}', [SaleInvoiceController::class, 'update'])->where('saleinvoice', '^SV-(\d+)$');
    Route::get('/delete/{saleinvoice:InvoiceNo}', [SaleInvoiceController::class, 'destory'])->where('saleinvoice', '^SV-(\d+)$');

    Route::get('/details/{saleinvoice:InvoiceNo}', [SaleInvoiceController::class, 'viewDetails'])->where('saleinvoice', '^SV-(\d+)$');

    Route::get('/detailspreview/{saleinvoice:InvoiceNo}', [SaleInvoiceController::class, 'detailsPreview'])->where('saleinvoice', '^SV-(\d+)$');

    Route::get('/salesvoucher/{saleinvoice:InvoiceNo}', [SaleInvoiceController::class, 'printPreview'])->where('saleinvoice', '^SV-(\d+)$');

    Route::get('/reports', [SaleInvoiceController::class, 'salesinvoicesreports']);
});

//Purchase and Item Arrival

Route::middleware('mymiddleware:purchase')->group(function () {
    // Purchase Invoice routes
    Route::prefix('purchaseinvoices')->group(function () {
        Route::get('/index', [PurchaseInvoiceController::class, 'index'])->name('purchaseinvoices');
        Route::get('/add', [PurchaseInvoiceController::class, 'create'])->name('addpurchaseinvoice');
        Route::post('/add', [PurchaseInvoiceController::class, 'store']);
        Route::get('/edit/{purchaseinvoice:InvoiceNo}', [PurchaseInvoiceController::class, 'show'])->where('purchaseinvoice', '^PV-(\d+)$');
        Route::post('/update/{purchaseinvoice:InvoiceNo}', [PurchaseInvoiceController::class, 'update'])->where('purchaseinvoice', '^PV-(\d+)$');
        Route::get('/delete/{purchaseinvoice:InvoiceNo}', [PurchaseInvoiceController::class, 'destory'])->where('purchaseinvoice', '^PV-(\d+)$');

        Route::get('/details/{purchaseinvoice:InvoiceNo}', [PurchaseInvoiceController::class, 'viewDetails'])->where('purchaseinvoice', '^PV-(\d+)$');

        Route::get('/printpuvoucher/{purchaseinvoice:InvoiceNo}', [PurchaseInvoiceController::class, 'printPreview'])->where('purchaseinvoice', '^PV-(\d+)$');

        Route::get('/pudetailspreview/{purchaseinvoice:InvoiceNo}', [PurchaseInvoiceController::class, 'detailsPreview'])->where('purchaseinvoice', '^PV-(\d+)$');

        Route::get('/reports', [PurchaseInvoiceController::class, 'purchaseinvoicesreports']);
    });

    // Item Arrival routes
    Route::prefix('itemarrival')->group(function () {
        Route::get('/index', [ItemArrivalController::class, 'index'])->name('itemarrivals');
        Route::get('/add', [ItemArrivalController::class, 'create'])->name('additemarrival');
        Route::post('/add', [ItemArrivalController::class, 'store']);
        Route::get('/edit/{itemarrival:ArrivalCode}', [ItemArrivalController::class, 'show'])->where('itemarrival', '^IA-(\d+)$');
        Route::post('/update/{itemarrival:ArrivalCode}', [ItemArrivalController::class, 'update'])->where('itemarrival', '^IA-(\d+)$');
        Route::get('/delete/{itemarrival:ArrivalCode}', [ItemArrivalController::class, 'destory'])->where('itemarrival', '^IA-(\d+)$');
        Route::get('/reports', [ItemArrivalController::class, 'itemarrivalreports']);
    });
});
