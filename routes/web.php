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
});