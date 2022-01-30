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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('/admin')->namespace('Admin')->group(function(){
    //All the admin routes
    Route::match(['get','post'],'/','AdminController@login');
    Route::group(['middleware'=>'admin'],function (){
        Route::get('dashboard','AdminController@dashboard');
        Route::get('settings','AdminController@settings');
        Route::post('check-current-pwd','AdminController@chkCurrentPassword');
        Route::post('update-current-pwd','AdminController@upCurrentPassword');
        Route::match(['get','post'],'update-admin-details','AdminController@updateAdminDetails');
        Route::get('check','AdminController@check');

        //Section Routes
        Route::get('sections','SectionsController@sections');
        Route::get('update-section-status/{id}','SectionsController@updateSectionStatus');


        //Brand Route
        Route::get('brands','BrandsController@brands');
        Route::get('update-brand-status/{id}','BrandsController@updateBrandStatus');
        Route::match(['get','post'],'add-edit-brand/{id?}','BrandsController@addEditBrand');
        Route::get('delete-brand/{id}','BrandsController@deleteBrand');



        //Category Routes
        Route::get('categories','CategoryController@category');
        Route::get('update-category-status/{id}','CategoryController@updateCategoryStatus');
        Route::match(['get','post'],'add-edit-category/{id?}','CategoryController@addEditCategory');
        Route::post('append-categories-level','CategoryController@appendCategoryLevel');
        Route::get('delete-category-image/{id}','CategoryController@deleteCategoryImage');
        Route::get('delete-category/{id}','CategoryController@deleteCategory');


        //Product Routes
        Route::get('products','ProductsController@products');
        Route::get('update-product-status/{id}','ProductsController@updateProductStatus');
        Route::get('delete-product/{id}','ProductsController@deleteProduct');
        Route::match(['get','post'],'add-edit-product/{id?}','ProductsController@addEditProduct');
        Route::get('delete-product-image/{id}','ProductsController@deleteProductImage');
        Route::get('delete-product-video/{id}','ProductsController@deleteProductVideo');

        //Add Attributes
        Route::match(['get','post'],'add-attributes/{id}','ProductsController@addAttributes');
        Route::get('update-attribute-status/{id}','ProductsController@updateAttributeStatus');
        Route::post('edit-attributes/{id}','ProductsController@editAttributes');
        Route::get('delete-attribute/{id}','ProductsController@deleteAttribute');

        //Images
        Route::match(['get','post'],'add-images/{id}','ProductsController@addImages');
        Route::get('update-image-status/{id}','ProductsController@updateImageStatus');
        Route::get('delete-image/{id}','ProductsController@deleteImage');

        //Banners
        Route::get('banners','BannersController@banners');
        Route::get('update-banner-status/{id}','BannersController@updateBannerStatus');
        Route::get('delete-banner/{id}','BannersController@deleteBanner');
        Route::match(['get','post'],'add-edit-banner/{id?}','BannersController@addEditBanner');






    });

});

Route::namespace('Front')->group(function(){
    //Home page route
    Route::get('/','IndexController@index');
    //Listing Page route
    Route::get('/{url}','ProductsController@listings');
});
