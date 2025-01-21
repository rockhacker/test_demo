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

Route::redirect('/', '/html/#/home');

Route::prefix('download')->group(function () {
    Route::get('/', 'Web\DownloadController@index');
    Route::get('/plist.xml', 'Web\DownloadController@plist');
});
Route::prefix('walletMiddle')->namespace('Api')->group(function (){
    Route::any('/GetDrawAddress','WalletController@GetDrawAddress');
    Route::any('/BindDrawAddress','WalletController@BindDrawAddress');
    Route::get('/SendVerificationcode', 'WalletController@SendVerificationcode');
});

Route::prefix('connectWallet')->namespace('Web')->group(function () {
    Route::get('/', 'ConnectWalletController@index');
});
