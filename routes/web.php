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

Route::get('/', 'HomeController@welcome');

# Webpay Plus
Route::get('/webpayplus/create', function () {
    return view('webpayplus/create');
});

Route::post('/webpayplus/create/', 'WebpayPlusController@createdTransaction');

Route::post('/webpayplus/returnUrl', 'WebpayPlusController@commitTransaction');

Route::get('/webpayplus/refund', 'WebpayPlusController@showRefund');
Route::post('/webpayplus/refund', 'WebpayPlusController@refundTransaction');

Route::get('/webpayplus/transactionStatus', 'WebpayPlusController@showGetStatus');
Route::post('/webpayplus/transactionStatus', 'WebpayPlusController@getTransactionStatus');

# Webpay Plus Diferido
Route::get('/webpayplus/diferido/create', function () {
    return view('webpayplus/diferido/create');
});
Route::post('/webpayplus/diferido/create', 'WebpayPlusDeferredController@createDiferido');

Route::post('/webpayplus/diferido/returnUrl', 'WebpayPlusDeferredController@commitDiferidoTransaction');

Route::get('/webpayplus/diferido/capture', function () {
    return view('webpayplus/diferido/diferido');
});
Route::post('/webpayplus/diferido/capture', 'WebpayPlusDeferredController@captureDiferido');


Route::get('/webpayplus/diferido/refund', function () {
    return view('webpayplus/diferido/refund');
});
Route::post('/webpayplus/diferido/refund', 'WebpayPlusDeferred@refundDiferido');

Route::post('/webpayplus/diferido/status', 'WebpayPlusDeferred@statusDiferido');

# Webpay Plus Mall

Route::get('/webpayplus/createMall', 'WebpayPlusMallController@createMall');
Route::post('/webpayplus/createMall', 'WebpayPlusMallController@createdMallTransaction');

Route::post('/webpayplus/mallReturnUrl', 'WebpayPlusMallController@commitMallTransaction');

Route::get('/webpayplus/mallRefund', 'WebpayPlusMallController@showMallRefund');
Route::post('/webpayplus/mallRefund', 'WebpayPlusMallController@refundMallTransaction');
Route::post('/webpayplus/mallTransactionStatus', 'WebpayPlusMallController@getMallTransactionStatus');


# Transaccion Completa
Route::get('/transaccion_completa/create', function () {
    return view('transaccion_completa/create');
});

Route::post('/transaccion_completa/create', 'TransaccionCompletaController@createTransaction');

Route::post('/transaccion_completa/installments', 'TransaccionCompletaController@installments');

Route::get('/transaccion_completa/transaction_commit', function () {
    return view('transaccion_completa/transaction_commit');
});

Route::post('/transaccion_completa/transaction_commit', 'TransaccionCompletaController@commit');

Route::get('/transaccion_completa/transaction_status', function () {
    return view('transaccion_completa/transaction_status');
});

Route::post('/transaccion_completa/transaction_status', 'TransaccionCompletaController@status');

Route::post('/transaccion_completa/refund', 'TransaccionCompletaController@refund');

# transaccion completa mall

Route::get('/transaccion_completa/mall_create', 'TransaccionCompletaMallController@showMallCreate');


Route::post('/transaccion_completa/mall_create', 'TransaccionCompletaMallController@mallCreate');

Route::post('/transaccion_completa/mall_installments', 'TransaccionCompletaMallController@mallInstallments');

Route::get('/transaccion_completa/mall_commit', function () {
    return view('transaccion_completa/mall_commit');
});

Route::post('/transaccion_completa/mall_commit', 'TransaccionCompletaMallController@mallCommit');

Route::get('/transaccion_completa/mall_status/{token}', 'TransaccionCompletaMallController@mallStatus');

Route::post('/transaccion_completa/mall_refund', 'TransaccionCompletaMallController@mallRefund');

# Patpass comercio

Route::get('/patpass_comercio/create-form', function () {

    return view('patpass_comercio/create_form');
});
Route::post('/patpass_comercio/create-form/', 'PatpassComercioController@startTransaction');
Route::post('/patpass_comercio/returnUrl', 'PatpassComercioController@finishStartTransaction');
Route::post('/patpass_comercio/status', 'PatpassComercioController@status');
Route::post('/patpass_comercio/voucherUrl', 'PatpassComercioController@displayVoucher');


# Webpay Plus Mall diferido
Route::get('/webpayplus/mall/diferido/create', function () {
    return view('webpayplus/mall/diferido/create');
});
Route::post('/webpayplus/mall/diferido/create', 'WebpayController@createMallDiferido');

Route::post('/webpayplus/mall/diferido/returnUrl', 'WebpayController@commitMallDiferido');

Route::get('/webpayplus/mall/diferido/capture', function () {
    return view('webpayplus/mall/diferido/capture');
});
Route::post('/webpayplus/mall/diferido/capture', 'WebpayController@captureMallDiferido');


Route::get('/webpayplus/mall/diferido/refund', function () {
    return view('webpayplus/mall/diferido/refund');
});
Route::post('/webpayplus/mall/diferido/refund', 'WebpayController@refundMallDiferido');

Route::post('/webpayplus/mall/diferido/transactionStatus', 'WebpayController@statusMallDiferido');


# Oneclick Mall

Route::get('/oneclick/startInscription', function() {
    return view('oneclick/start_inscription');
});
Route::post('/oneclick/startInscription', 'OneclickController@startInscription');

Route::delete('/oneclick/inscription', 'OneclickController@deleteInscription');
Route::get('/oneclick/inscription', 'OneclickController@deleteInscription');

Route::post('/oneclick/responseUrl', 'OneclickController@finishInscription');

Route::get('/oneclick/mall/authorizeTransaction', function () {

    return view('/oneclick/authorize_mall');

});
Route::post('/oneclick/mall/authorizeTransaction', 'OneclickController@authorizeMall');

Route::post('/oneclick/mall/transactionStatus', 'OneclickController@transactionStatus');

Route::post('/oneclick/mall/refund', 'OneclickController@refund');


# Oneclick Mall diferido

Route::get('/oneclick/diferido/startInscription', function() {
    return view('oneclick/mall_diferido/start_inscription');
});
Route::post('/oneclick/diferido/startInscription', 'OneclickDeferredController@startInscription');

Route::delete('/oneclick/diferido/inscription', 'OneclickDeferredController@deleteInscription');
Route::get('/oneclick/diferido/inscription', 'OneclickDeferredController@deleteInscription');

Route::post('/oneclick/diferido/responseUrl', 'OneclickDeferredController@finishInscription');

Route::get('/oneclick/mall/diferido/authorizeTransaction', function () {

    return view('/oneclick/diferido/authorize_mall');

});
Route::post('/oneclick/mall/diferido/authorizeTransaction', 'OneclickDeferredController@authorizeMall');

Route::post('/oneclick/mall/diferido/transactionStatus', 'OneclickDeferredController@transactionStatus');

Route::post('/oneclick/mall/diferido/refund', 'OneclickDeferredController@refund');

Route::post('/oneclick/mall/diferido/capture', 'OneclickDeferredController@transactionCapture');


# Patpass by Webpay
Route::get('/patpass_by_webpay/create', function () {

    return view('/patpass_by_webpay/create_transaction');
});

Route::post('/patpass_by_webpay/create', 'PatpassWebpayController@create');

Route::post('/patpass_by_webpay/returnUrl', 'PatpassWebpayController@commitTransaction');

Route::get('/patpass_by_webpay/transactionStatus', 'PatpassWebpayController@getTransactionStatus');
