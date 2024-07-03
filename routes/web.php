<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\UserController;
use App\Models\Hotel;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    $hotels = Hotel::all();
    return view('index',compact('hotels'));
})->name('index');

Route::post('/login',[UserController::class,'login'])->name('login');
Route::post('/register',[UserController::class,'register'])->name('register');

Route::get('/logout',[UserController::class,'logout'])->name('logout');
Route::resource('customers', CustomerController::class);

Route::prefix('admin')->group(function(){
    Route::get('/dashboard',[AdminController::class,'getDashboardAdmin'])->name('admin_dashboard');
    Route::get('/hotels',[AdminController::class,'getHotels'])->name('admin_hotels');
    Route::get('/produks',[AdminController::class,'getProduks'])->name('admin_produk');
    Route::get('/transactions',[AdminController::class,'getTransactions'])->name('admin_transactions');
    Route::get('/customers',[AdminController::class,'getCustomers'])->name('admin_customers');

    Route::post('/addHotel',[AdminController::class,'addHotel'])->name('admin_add_hotels');
    Route::post('/addTypeHotel',[AdminController::class,'addTypeHotel'])->name('admin_add_type_hotel');
    Route::post('/addProduk',[AdminController::class,'addProduk'])->name('admin_add_produk');
    Route::post('/addTypeProduk',[AdminController::class,'addTypeProduk'])->name('admin_add_type_produk');
    Route::post('/addMember',[AdminController::class,'addMember'])->name('admin_add_member');

    Route::post('/editHotel',[AdminController::class,'editHotel'])->name('admin_edit_hotel');
    Route::post('/editProduk',[AdminController::class,'editProduk'])->name('admin_edit_produk');

    Route::get('/dashboard/customer/{id}',[AdminController::class,'getCustomerDetails'])->name('admin_customer_details');
    Route::get('/dashboard/hotel/{id}',[AdminController::class,'getHotelDetails'])->name('admin_hotel_details');
    Route::get('/dashboard/produk/{id}',[AdminController::class,'getProductDetails'])->name('admin_produk_details');

    Route::get('/transactions/details',[AdminController::class,'getTransactionDetails'])->name('admin_transaction_details');
    Route::post('products', [AdminController::class, 'storeProduct'])->name('products.store');
Route::post('product-types', [AdminController::class, 'storeProductType'])->name('product-types.store');
});

Route::prefix('pelanggan')->group(function(){
    Route::get('/profile',[PelangganController::class,''])->name('pelanggan_profile');
    Route::get('/detailHotel/{id}',[PelangganController::class,'detailHotel'])->name('hotel_detail');

    Route::post('/reservasi',[PelangganController::class,'reservasi'])->name('pelanggan_reservasi');
});
