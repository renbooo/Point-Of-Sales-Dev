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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => ['web', 'usercheck:1']],
function(){
	Route::get('category/data', 'CategoryController@listData')->name('category.data');
	Route::resource('category', 'CategoryController');

	Route::get('product/data', 'ProductController@listData')->name('product.data');
	Route::post('product/delete', 'ProductController@deleteSelected');
	Route::post('product/print', 'ProductController@printBarcode');
	Route::resource('product', 'ProductController');

	Route::get('supplier/data', 'SupplierController@listData')->name('supplier.data');
	Route::resource('supplier', 'SupplierController');

	Route::get('member/data', 'MemberController@listData')->name('member.data');
	Route::post('member/print', 'MemberController@printCard');
	Route::resource('member', 'MemberController');

	Route::get('spending/data', 'SpendingController@listData')->name('spending.data');
	Route::resource('spending', 'SpendingController');

	Route::get('user/data', 'UserController@listData')->name('user.data');
	Route::resource('user', 'UserController');

	Route::get('purchase/data', 'PurchaseController@listData')->name('purchase.data');
	Route::get('purchase/{id}/add', 'PurchaseController@create');
	Route::get('purchase/{id}/show', 'PurchaseController@show');
	Route::resource('purchase', 'PurchaseController');

	Route::get('purchase_details/{id}/data', 'PurchaseDetailsController@listData')->name('purchase_details.data');
	Route::get('purchase_details/loadform/{discount}/{total}', 'PurchaseDetailsController@loadForm');
	Route::resource('purchase_details', 'PurchaseDetailsController');

	Route::get('selling/data', 'SellingController@listData')->name('selling.data');
	Route::get('selling/{id}/show', 'SellingController@show');
	Route::resource('selling', 'SellingController');

	Route::get('report', 'ReportController@index')->name('report.index');
   Route::post('report', 'ReportController@refresh')->name('report.refresh');
   Route::get('report/data/{begin}/{end}', 'ReportController@listData')->name('report.data'); 
   Route::get('report/pdf/{begin}/{end}', 'ReportController@exportPDF');
   Route::resource('setting', 'SettingController');

});

Route::group(['middleware' => 'web'], function(){
	Route::get('user/profile', 'UserController@show')->name('user.profile');
	Route::patch('user/{id}/change', 'UserController@changeProfile');

	Route::get('
transaction/new', 'SellingDetailsController@newSession')->name('transaction.new');
   Route::get('
transaction/{id}/data', 'SellingDetailsController@listData')->name('
transaction.data');
   Route::get('transaction/printnote', 'SellingDetailsController@printNote')->name('transaction.print');
   Route::get('transaction/notepdf', 'SellingDetailsController@notePDF')->name('transaction.pdf');
   Route::post('transaction/save', 'SellingDetailsController@saveData');
   Route::get('transaction/loadform/{discount}/{total}/{received}', 'SellingDetailsController@loadForm');
   Route::resource('transaction', 'SellingDetailsController');
});