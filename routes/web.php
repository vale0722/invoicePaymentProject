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

Route::get('/', 'InvoiceController@index')->name('home');
Route::get('/invoice/create', 'InvoiceController@create')->name('invoice.create');
Route::get('invoice/{invoice}', 'InvoiceController@show')->name('invoice.show');
Route::post('/invoice/create', 'InvoiceController@store')->name('invoice.store');
Route::get('/invoice/edit/{invoice}', 'InvoiceController@edit')->name('invoice.edit');
Route::put('/invoice/edit/{invoice}', 'InvoiceController@update')->name('invoice.update');
Route::post('/invoice/annul/{invoice}', 'InvoiceController@annulate')->name('invoice.annulate');
Route::get('/invoice/annul/{invoice}', 'InvoiceController@annulateView')->name('invoice.annulate.view');
Route::get('/invoice/annul/cancel/{invoice}', 'InvoiceController@annulateCancel')->name('invoice.annulate.cancel');

Route::get('/invoice/{invoice}/product/create', 'InvoiceProductController@create')
        ->name('invoice.product.create');
Route::post('/invoice/{invoice}/product/create', 'InvoiceProductController@store')
        ->name('invoice.product.store');

Route::get('/payment/{invoice}', 'PaymentController@index')->name('payment.index');
Route::post('/payment/create/{invoice}', 'PaymentController@store')->name('payment.store');
Route::get('/payment/show/{payment}', 'PaymentController@show')->name('payment.show');
Route::get('/payment/update/{payment}', 'PaymentController@update')->name('payment.update');

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');