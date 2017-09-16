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

Route::get('/', 'PublicController@index');
Route::get('get_pages', 'PublicController@getPages');
Route::post('contact', 'PublicController@contact');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function (){

    Route::resource('hours', 'HourController');
    Route::post('update_hours', 'HourController@updateHours');
    Route::post('update_hours_message', 'HourController@updateHoursMsg');

    Route::resource('admin', 'AdminController');
    Route::get('newadmin', 'AdminController@newAdmin')->name('newAdmin');
    Route::post('storeadmin', 'AdminController@storeAdmin');
    Route::get('logout', 'AdminController@logout');

    Route::resource('items', 'ItemController', ['only' => ['show', 'index', 'edit', 'store']]);
    Route::post('update_item', 'ItemController@updateItem');
    Route::get('delete_item/{id}', 'ItemController@DeleteItem');

    Route::resource('cake_items', 'CakeItemController');
    Route::post('update_cake_item', 'CakeItemController@updateItem');
    Route::get('delete_cake_item/{id}', 'CakeItemController@DeleteItem');

    Route::post('store_cat_cakes', 'CategoryCakesController@storeCat');
    Route::get('update_cat_cakes/{id}', 'CategoryCakesController@updateCat');
    Route::get('delete_cat_cakes/{id}', 'CategoryCakesController@deleteCat');
    Route::get('hide_cat_cakes/{id}', 'CategoryCakesController@hideCat');

    Route::resource('category', 'CategoryController', ['only' => ['store']]);
    Route::get('update_cat/{id}', 'CategoryController@updateCat');
    Route::get('delete_cat/{id}', 'CategoryController@deleteCat');
    Route::get('hide_cat/{id}', 'CategoryController@hideCat');

    Route::get('home', 'HomeController@index');
    Route::get('home_items/{id}', 'HomeController@getItems');
    Route::get('item_selected/{id}', 'HomeController@itemSelected');
    Route::get('home_item_changed/{id}', 'HomeController@itemChanged');
    Route::get('update_item/{id}', 'HomeController@updateItem');
    Route::post('update_home_body', 'HomeController@updateHomeBody');

    Route::get('about', 'AboutController@index');
    Route::post('update_about', 'AboutController@updateAbout');

    Route::get('contact', 'ContactController@index');
    Route::post('update_contact', 'ContactController@updateContact');

    /*Open for buiness*/
    Route::post('toggle_open_close', 'OrderController@CheckStoreStatus');
    Route::get('get_order_updates', 'OrderController@getOrderUpdates');
    Route::post('reply_to_customer', 'OrderController@emailCustomer');
    Route::post('cancel_cust_order', 'OrderController@cancelOrder');
    Route::get('check_order_count/{count}', 'OrderController@orderCount');

});

Route::get('users/verify/{token}', 'AdminController@verify')->name('verify');
Route::post('users', 'AdminController@store')->name('saveUser');

Route::post('send_message', 'ContactController@SendMessage');

/*Displaying the menu*/
Route::get('change_category/{id}', 'PublicItemsController@changeCategory');
Route::get('change_cake_category/{id}', 'PublicItemsController@changeCakeCategory');

/*Order form*/
Route::post('add_order_form', 'PublicItemsController@orderForm');
Route::post('add_cake_order_frm', 'PublicItemsController@orderCakeForm');
Route::post('order_updated', 'PublicItemsController@updateOrderForm');
Route::get('get_order_form', 'PublicItemsController@getOrderForm');
Route::get('delete_row_item/{id}', 'PublicItemsController@deleteItem');

/*Customer Check Out*/
Route::resource('customer', 'CustomerController', ['only' => ['store']]);
Route::get('search_cust_email/{email}', 'CustomerController@getEmail');
Route::get('get_past_orders/{cust_id}', 'CustomerController@pastOrders');
Route::post('re_order', 'CustomerController@reorder');
Route::get('delete_order/{order_id}', 'CustomerController@deleteOrder');



