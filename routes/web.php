<?php
Route::get('/', 'Website\HomeController@index');
Route::any('/age-varify', 'Website\HomeController@storeCache');
Auth::routes();
Route::any('/register', 'Website\HomeController@userRegister')->name('register');
Route::get('auth/google', [App\Http\Controllers\Website\UserController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [App\Http\Controllers\Website\UserController::class, 'handleGoogleCallback']);
//Route::middleware(['checkUser'])->group(function () {
       Route::get('/product', 'Website\ProductController@index')->name('product');
       Route::get('/product-details', 'Website\ProductController@details')->name('product.details');
       Route::get('/product-brand', 'Website\ProductController@productBrand')->name('product.brand');
       Route::any('/contact-us', 'Website\ContactUsController@index');
       Route::get('/about-us', 'Website\ContactUsController@aboutUs');
       Route::get('/term-condition', 'Website\ContactUsController@terms');
       Route::get('/privacy', 'Website\ContactUsController@privacy');
       Route::get('/businesses', 'Website\ContactUsController@businesses');
       Route::get('/learn', 'Website\ContactUsController@learn');
       Route::get('/branch', 'Website\ContactUsController@branch');
       Route::any('/productdata', 'Website\ProductController@productData');
       Route::post('/addwishlist', 'Website\ProductController@wishlistAdd');


       // vendors module
       Route::get('/vendors', 'Website\VendorController@index')->name('vendors');
       Route::get('/vendor-details', 'Website\VendorController@details')->name('vendor-details');

        // Chef module
        Route::get('/chefs', 'Website\ChefController@index')->name('chefs');
        Route::get('/chef-details', 'Website\ChefController@details')->name('chef-details');

        // Chef module
        Route::get('/restaurants', 'Website\RestaurantController@index')->name('restaurants');
        Route::get('/restaurant-details', 'Website\RestaurantController@details')->name('restaurants-details');
       
       
    Route::middleware(['auth'])->group(function () {
        Route::get('/add-wish-list', 'Website\ProductController@addWishlist'); 
        Route::get('/wish-list', 'Website\ProductController@wishlist');
        Route::get('/remove-wishlist', 'Website\ProductController@removeWishlist');
        Route::any('/profile-setting', 'Website\UserController@profileSetting');
        Route::any('/submit-review', 'Website\ProductReviewController@submitReview');
        Route::post('/request-order', 'Website\InquiryController@store')->name('request-order');

    });
//}); 
// Admin routes 
Route::redirect('/admin', '/admin/login');
Route::any('/admin/login', 'Admin\AuthController@login')->name('admin/login');
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::middleware(['checkAdmin'])->group(function () {
        Route::get('home', 'HomeController@adminHome')->name('home');
        Route::get('index', 'AdminController@index')->name('index');
        Route::get('users', 'CustomerController@index')->name('users');
        Route::get('vendor-accounts', 'Admin\VendorsController@index')->name('vendors');
        Route::post('updateProfile', 'AdminController@updateProfile')->name('updateProfile');
        Route::post('updatePassword', 'AdminController@updatePassword')->name('updatePassword'); 
        Route::resource('category', 'CategoriesController');
        Route::resource('vendor-category', 'VendorCategoryController');
        Route::resource('product', 'ProductController');
        Route::resource('provider', 'ProviderController');
        Route::resource('brand', 'BrandController');
        Route::resource('tag', 'TagController');
        Route::resource('testimonial', 'TestimonialController');
        Route::get('contact', 'ContactUsController@index')->name('contact');
        Route::post('updateStatus', 'StatusController@updateStatus')->name('updateStatus');
        Route::post('updateFeatures', 'StatusController@updateFeatures')->name('updateFeatures');
        Route::post('updateRecommended', 'StatusController@updateRecommended')->name('updateRecommended');
        Route::post('changestate', 'CategoriesController@changeState');
    });
});

// Vender Route 
Route::redirect('/vendor', '/admin/login');
Route::any('vendor/signup', 'Admin\AuthController@registerVendor');
Route::group(['prefix' => 'vendor', 'as' => 'vendor.'], function () {
    Route::middleware(['vendor'])->group(function () {
        Route::get('home', 'HomeController@adminHome')->name('home');
        Route::get('index', 'AdminController@index')->name('index');
        Route::post('updateProfile', 'AdminController@updateProfile')->name('updateProfile');
        Route::post('updatePassword', 'AdminController@updatePassword')->name('updatePassword'); 
        Route::post('updateFeatures', 'StatusController@updateFeatures')->name('updateFeatures');
       //Route::resource('category', 'CategoriesController');
        Route::resource('product', 'ProductController');
        Route::get('inquiries', 'InquiriesController@index')->name('inquiries');
        Route::post('inquiries/update-status', 'InquiriesController@updateStatus')->name('inquiries.update-status');
        Route::any('setting', 'SubscriptionController@index')->name('setting');
        Route::any('add-account', 'SubscriptionController@addAccount')->name('add-account');
        Route::any('verify-subscribtion', 'SubscriptionController@verifySubscription')->name('verify-subscribtion');
    });
});

Route::middleware(['vendor'])->group(function () {
    Route::get('/stripe', 'Website\StripePaymentController@stripe');
    Route::post('/stripe', 'Website\StripePaymentController@stripePost')->name('stripe.post');
});
// Route::controller(Website\StripePaymentController::class)->group(function(){
//     Route::get('stripe', 'stripe');
//     Route::post('stripe', 'stripePost')->name('stripe.post');
// });


