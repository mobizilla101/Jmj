<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Auth::routes(['verify' => true]);

Route::controller(\App\Http\Controllers\ProfileController::class)->middleware('auth')->group(function(){
    Route::get('profile','index')->name('auth.profile');
    Route::get('profile/security','security')->name('auth.profile.security');
    Route::get('profile/password/change','edit');
    Route::put('profile/password/change','update')->name('auth.password.change');
    Route::get('profile/orders','orders')->name('auth.profile.orders');
    Route::get('profile/orders/{order}','orderView')->name('auth.profile.orders.view');
});

Route::get('auth/google',[\App\Http\Controllers\GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback',[\App\Http\Controllers\GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);

Route::get('/about', [\App\Http\Controllers\AboutControler::class, 'index'])->name('about');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::controller(ProductController::class)->group(function(){
    Route::get('new/products','index')->name('buy');
    Route::get('new/products/{brand:slug}','search')->name('product.brand.search');
    Route::get('new/products/{model:slug}/show','show')->name('product.show');
    Route::get('new/products/{model:slug}/preview','preview')->name('product.preview');
});

Route::controller(\App\Http\Controllers\UsedController::class)->group(function(){
    Route::get('used/product','index')->name('used');
    Route::get('used/product/{brand:slug}','search')->name('used.product.brand.search');
    Route::get('used/product/{secondhandInventory}/show','show')->name('used.show');
    Route::get('used/cart/add/{secondhandInventory}','addToCart')->name('used.add.cart');
});

Route::controller(\App\Http\Controllers\RefurbController::class)->group(function(){
    Route::get('refurbed/products','index')->name('refurb');
    Route::get('refurbed/product/{brand:slug}','search')->name('refurbed.product.brand.search');
    Route::get('refurbed/products/{secondhandInventory}','show')->name('refurb.show');
    Route::get('refurb/cart/add/{secondhandInventory}','addToCart')->name('used.add.cart');
});

Route::get('sell', [\App\Http\Controllers\SellControler::class, 'index'])->name('sell');
Route::get('repair', [\App\Http\Controllers\RepairControler::class, 'index'])->name('repair');


Route::get('services', [\App\Http\Controllers\ServicesControler::class, 'index'])->name('services');


Route::controller(\App\Http\Controllers\CartController::class)->group(
    function(){
        Route::get('/cart','index')->name('cart');
        Route::get('/cart/add/{sku}','store')->name('cart.add');
        Route::get('/cart/update/{sku}','update')->name('cart.update');
    }
);

Route::controller(\App\Http\Controllers\CheckoutController::class)->middleware('auth')->group(
    function(){
        Route::get('/checkout','index')->name('checkout');
        Route::post('/checkout','create')->name('checkout');
        Route::get('/checkout/cancel','cancel')->name('checkout.cancel');
    }
);

Route::controller(\App\Http\Controllers\BlogController::class)->group(function(){
    Route::get('/blog','index')->name('blog');
    Route::get('/blog/{blog:slug}','show')->name('blog.show');
    Route::get('/blog/{blog:slug}/preview','preview')->name('blog.preview');
});


Route::get('/coming-soon',[\App\Http\Controllers\ComingSoonController::class,'index'])->name('coming-soon');

Route::controller(\App\Http\Controllers\PartsController::class)->group(function(){
    Route::get('/parts','index')->name('parts');
    Route::get('/parts/category','category')->name('parts.category');
    Route::get('/parts/{parts}/preview','preview')->name('parts.preview');
    Route::get('/parts/show/{parts}','show')->name('parts.show');
    Route::get('/parts/cart/add/{part}/{quantity}','addToCart')->name('parts.cart.add');
});

Route::get('faq',[\App\Http\Controllers\FaqController::class,'index'])->name('faq');

Route::controller(\App\Http\Controllers\MachineController::class)->group(function(){
    Route::get('/machine','index')->name('machine');
    Route::get('/machine/{machinery}/preview','preview')->name('machine.preview');
    Route::get('/machine/{machinery}','show')->name('machine.show');
    Route::get('/machine/cart/add/{machinery}/{quantity}','addToCart')->name('machine.cart.add');
});


Route::controller(\App\Http\Controllers\AccessoriesController::class)->name('accessories.')->prefix('accessories')->group(function(){
    Route::get('/','index')->name('index');
    Route::get('/show/{accessory:slug}','show')->name('show');
    Route::get('/show/preview/{accessory:slug}','preview')->name('preview');
    Route::get('/cart/add/{accessory:slug}/{quantity}','addToCart')->name('cart.add');
});
