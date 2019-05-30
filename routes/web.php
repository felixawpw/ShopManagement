<?php

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
Route::get("/", 'HomeController@index');

Route::middleware(['auth'])->group(function(){
	Route::resource('barang', 'BarangController');
	Route::resource('supplier', 'SupplierController');
	Route::resource('pembelian', 'PembelianController');
	Route::resource('penjualan', 'PenjualanController');
	Route::resource('customer', 'CustomerController');
	Route::resource('pegawai', 'PegawaiController');
	Route::resource('absen', 'AbsenController');
	Route::resource('brand', 'BrandController');
	Route::resource('product-type', 'ProductTypeController');

	Route::get('/report/penjualan', 'ReportController@showPenjualan')->name('report_penjualan_show');
	Route::get('/report/pembelian', 'ReportController@showPembelian')->name('report_pembelian_show');

	Route::get('/report/generate/penjualan', 'ReportController@generatePenjualan')->name('report_generate_penjualan');
	Route::get('/report/generate/pembelian', 'ReportController@generatePembelian')->name('report_generate_pembelian');
	Route::get('/report/generate/stok', 'ReportController@generateStok')->name('report_generate_stok');

	Route::get('/barang/report/penjualan/{id}', 'BarangController@reportPenjualan')->name("show_barang_penjualan");
	Route::get('/barang/report/pembelian/{id}', 'BarangController@reportPembelian')->name("show_barang_pembelian");

	Route::get('/barang/json', 'BarangController@json');
	Route::get('/supplier/json', 'SupplierController@json');
	Route::get('/pegawai/json', 'PegawaiController@json');
	Route::get('/customer/json', 'CustomerController@json');
	Route::get('/pembelian/json', 'PembelianController@json');
	Route::get('/penjualan/json', 'PenjualanController@json');

	Route::get('/home', 'HomeController@index')->name('home');

	Route::post('/ajax/barang/load', 'BarangController@json')->name('barang_load');
	Route::post('/ajax/supplier/load', 'SupplierController@json')->name('supplier_load');
	Route::post('/ajax/customer/load', 'CustomerController@json')->name('customer_load');
	Route::post('/ajax/pembelian/load', 'PembelianController@json')->name('pembelian_load');
	Route::post('/ajax/penjualan/load', 'PenjualanController@json')->name('penjualan_load');

	Route::post('/ajax/barang-penjualan/load/{id}', 'BarangController@barangPembelianJSON')->name('barang_pembelian_load');

	Route::get('/selectize/barang/load', 'BarangController@selectize')->name('selectize_barang');
	Route::get('/selectize/customer/load', 'CustomerController@selectize')->name('selectize_customer');
	Route::get('/selectize/supplier/load', 'SupplierController@selectize')->name('selectize_supplier');

	Route::get('/ajax/add/supplier', 'AjaxController@addSupplier');
	Route::post('/ajax/add/supplier', 'AjaxController@storeSupplier');

	Route::get('/ajax/add/customer', 'AjaxController@addCustomer');
	Route::post('/ajax/add/customer', 'AjaxController@storeCustomer');
	
	Route::get('/invoice/{id}', 'PenjualanController@invoice')->name('invoice');
	Route::get('/suratjalan/{id}', 'PenjualanController@suratjalan')->name('suratjalan');
});

Route::get('/test', 'AjaxController@test');

Route::get('login', 'AuthController@showLogin')->name('login');
Route::post('login', 'AuthController@login')->name('do_login');

Route::get('lock', 'AuthController@showLock');
Route::post('lock', 'AuthController@lock');

Route::post('logout', 'AuthController@logout')->name('logout');
