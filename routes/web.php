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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('root');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['admin'])->group(function () {
    Route::get('/dashboard', 'AdminController@index')->name('dashboard');
    Route::resource('/items', 'ItemController');

    Route::get('/bookings', 'BookingController@index')->name('bookings.index');
    Route::get('/bookings/{id}', 'BookingController@show')->name('bookings.show');
    Route::delete('/bookings/{id}', 'BookingController@destroy')->name('bookings.destroy');

    Route::get('/bookings/{id}/approve', 'BookingController@approve')->name('bookings.approve');
    Route::get('/bookings/{id}/complete', 'BookingController@complete')->name('bookings.complete');
    Route::get('/bookings/export/excel', 'BookingController@exportExcel')->name('bookings.export_excel');
    Route::get('/bookings/export/pdf', 'BookingController@exportPdf')->name('bookings.export_pdf');
    Route::post('/bookings/bulk-delete', 'BookingController@bulkDelete')->name('bookings.bulk_delete');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/bookings/create/{item_id}', 'BookingController@create')->name('bookings.create');
    Route::POST('/bookings', 'BookingController@store')->name('bookings.store');
    Route::get('/my-bookings', 'BookingController@myBookings')->name('bookings.mine');
});


