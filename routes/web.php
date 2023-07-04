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
       Route::any('/verify', 'Website\OrderController@verifyPayment');
       Route::post('/addwishlist', 'Website\ProductController@wishlistAdd');
       Route::post('/addtocart', 'Website\ProductController@addcart');


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
        //Route::get('/shoping-cart', 'Website\UserController@shopingCart'); 
        Route::post('/updateCart', 'Website\CartController@updateCart')->name('updateCart');
        Route::post('/deleteCart', 'Website\CartController@deleteCart')->name('deleteCart');  
        Route::get('/shoping-cart', 'Website\CartController@index'); 
        Route::any('/addcartlist', 'Website\CartController@addToCart');
        Route::any('/save-address', 'Website\UserController@saveAddress');
        Route::any('/movetocart', 'Website\CartController@moveToCart');
        Route::any('/delete-cart-product/{id?}', 'Website\CartController@removeCartProduct');
        Route::any('/billing-address', 'Website\UserController@billingAddress');
        Route::any('/checkout', 'Website\UserController@checkout');
        Route::any('/order-history', 'Website\OrderController@orderHistory');
        Route::any('/product-checkout', 'Website\OrderController@productCheckout')->name('product_checkout');
        Route::any('/submit-review', 'Website\ProductReviewController@submitReview');
        Route::any('/order-details', 'Website\OrderController@orderDetails');
        Route::any('/removecart', 'Website\ProductController@removeCart');
        Route::any('/order-rating', 'Website\ProductReviewController@orderRating')->name('order-rating');
          Route::any('addUserCard','Website\CardController@addUserCard')->name('users.addUserCard');

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
        Route::post('updateProfile', 'AdminController@updateProfile')->name('updateProfile');
        Route::post('updatePassword', 'AdminController@updatePassword')->name('updatePassword'); 
        Route::resource('category', 'CategoriesController');
        Route::resource('vendor-category', 'VendorCategoryController');
        Route::resource('product', 'ProductController');
        Route::resource('provider', 'ProviderController');
        Route::resource('brand', 'BrandController');
        Route::resource('tag', 'TagController');
        Route::resource('testimonial', 'TestimonialController');
        Route::get('orders', 'OrderController@index')->name('orders');
        Route::get('contact', 'ContactUsController@index')->name('contact');
        Route::post('updateStatus', 'StatusController@updateStatus')->name('updateStatus');
        Route::post('updateFeatures', 'StatusController@updateFeatures')->name('updateFeatures');
        Route::post('updateRecommended', 'StatusController@updateRecommended')->name('updateRecommended');
        Route::post('changestate', 'CategoriesController@changeState');
        Route::get('show-order', 'OrderController@showOrder');
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
       // Route::get('orders', 'OrderController@index')->name('orders');
        Route::get('orders', 'OrderController@index')->name('orders');
        Route::any('update-order', 'OrderController@updateOrder');
        Route::get('show-order', 'OrderController@showOrder');
        Route::get('sold-product', 'OrderController@soldProduct')->name('sold-product');
        Route::any('setting', 'SubscriptionController@index')->name('setting');
        Route::any('add-account', 'SubscriptionController@addAccount')->name('add-account');
        Route::any('verify-subscribtion', 'SubscriptionController@verifySubscription')->name('verify-subscribtion');
    });
});

Route::get('/stripe', 'Website\StripePaymentController@stripe');
Route::post('/stripe', 'Website\StripePaymentController@stripePost')->name('stripe.post');
//Route::any('/stripe', 'Website\StripePaymentController@stripe');
// Route::controller(Website\StripePaymentController::class)->group(function(){
//     Route::get('stripe', 'stripe');
//     Route::post('stripe', 'stripePost')->name('stripe.post');
// });


