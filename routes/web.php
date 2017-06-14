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

    Route::get('/','HomeController@index');
    
Route::group(['middleware' => 'guest'], function () {
    Route::get('login','AuthController@showLoginForm');
    Route::post('login','AuthController@login');
    Route::get('register','AuthController@showRegisterForm');
    Route::post('register','AuthController@register');

});

Route::group(['middleware' => 'auth'], function () {
    // Route::get('/','HomeController@index');

    Route::get('logout','AuthController@logout');


    Route::resource('image','ImageController');
    Route::resource('container','ContainerController');
    Route::resource('file', 'FileController');
    Route::get('file/{id}/show','FileController@show');


    /* Crud */
    Route::resource('users','UsersController');
    Route::resource('produsen','ProdusenController');
    Route::resource('konsumen','KonsumenController');
    Route::resource('crud/jenis','JenisController');
    Route::get('crud/jenis/{jenis}/konsumen/{konsumen}','JenisController@getKonsumen');
    Route::put('crud/jenis/{jenis}/konsumen/{konsumen}','JenisController@postKonsumen');
    Route::resource('crud/jenis_operasional','JenisOperasionalController');

    /* Transaksi pembelian dan penjualan, serta pengeluaran dan pembayaran */
    Route::get('transaksi/pembelian','TransaksiController@getPembelian');
    Route::post('transaksi/pembelian','TransaksiController@postPembelian');
    Route::get('transaksi/penjualan','TransaksiController@getPenjualan');
    Route::get('transaksi/penjualan/{konsumen}','TransaksiController@getPenjualan');
    Route::post('transaksi/penjualan','TransaksiController@postPenjualan');
    
    Route::resource('transaksi/pengeluaran','PengeluaranController');

    Route::get('transaksi/pembayaran','PembayaranController@index');
    Route::get('transaksi/pembayaran/create/konsumen/{konsumen}','PembayaranController@createKonsumen');
    Route::get('transaksi/pembayaran/create/nota/{nota}','PembayaranController@createNota');
    Route::post('transaksi/pembayaran','PembayaranController@store');
    Route::get('transaksi/pembayaran/kuitansi/{pembayaran}','PembayaranController@excelPembayaran');

    /* Laporan dll */
    Route::get('laporan/penjualan','LaporanTransaksiController@indexPenjualan');
    Route::get('laporan/penjualan/{id}','LaporanTransaksiController@showPenjualan');
    Route::get('laporan/penjualan/excel/{id}','LaporanTransaksiController@excelPenjualan');
    Route::get('laporan/pembelian','LaporanTransaksiController@indexPembelian');
    Route::get('laporan/pembelian/{id}','LaporanTransaksiController@showPembelian');
    Route::get('laporan/inventory/stok','LaporanInventoryController@stok');
    Route::get('laporan/inventory/harian','LaporanInventoryController@harian');

    /* Laporan grafik */
    Route::get('grafik/keuntungan_bersih','GrafikController@keuntunganBersih');
    Route::get('grafik/modal_aktual','GrafikController@modalAktual');
    Route::get('grafik/fresh_money','GrafikController@freshMoney');
    Route::get('grafik/penjualan_bulanan','GrafikController@penjualanBulanan');
    Route::get('grafik/komposisi_penjualan','GrafikController@komposisiPenjualan');
    Route::get('grafik/komposisi_operasional','GrafikController@komposisiOperasional');
    Route::get('grafik/komposisi_pengeluaran','GrafikController@komposisiPengeluaran');
    Route::get('grafik/pemasukan_pengeluaran','GrafikController@pemasukanPengeluaran');
    Route::get('grafik/modal_penjualan','GrafikController@modalPenjualan');
});
