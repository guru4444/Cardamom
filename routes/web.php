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

// Route::get('/', function () {
//     return view('home');
// });

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CustomersController;

Route::middleware(['auth'])->group(function () {

Route::get('/', [InventoryController::class, 'dash']);
Route::get('/report', [ReportController::class, 'dash']);
Route::get('/inventory', [InventoryController::class, 'dash']);
Route::get('/sales', [SalesController::class, 'dash']);
Route::get('/customers', [CustomersController::class, 'dash']);

Route::post('/save-inventory', [InventoryController::class, 'saveInventory']);

Route::post('/filter-by-date-range', [InventoryController::class, 'filterByDateRange'])->name('filterByDateRange');

Route::post('/sell-item', [InventoryController::class, 'sellItem']);
Route::post('/get-inventory-items', [SalesController::class, 'getInventoryItems']);

Route::resource('customers', CustomersController::class);

Route::post('/record-sale', [SalesController::class, 'recordSale']);
Route::get('/get-sales', [SalesController::class, 'getSales']);
Route::get('/get-sale-details/{id}', [SalesController::class, 'getSaleDetails']);
Route::post('/delete-sale/{id}', [SalesController::class, 'deleteSale']);

Route::get('/total-sales', [ReportController::class, 'getTotalSales']);
Route::get('/total-cost', [ReportController::class, 'getTotalCost']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});





Auth::routes();

