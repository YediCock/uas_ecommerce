<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login','\App\Livewire\Auth\Login')->name('login');
Route::get('/register','\App\Livewire\Auth\Register')->name('register');
Route::post('/logout', function(){
    Auth::logout();
    return redirect('/');
})->name('logout')->middleware('auth');
// admin
Route::prefix('admin')->middleware(['auth','admin'])->group(function () {
    Route::get('/dashboard','\App\Livewire\Admin\Dashboard\Dashboard');

    Route::get('/attribute', '\App\Livewire\Admin\Attribute\AttributeList');
    Route::get('/attribute/option/{id}', '\App\Livewire\Admin\Attribute\AttributeValueList')->name('attributeOption');

    Route::get('/setting', '\App\Livewire\Admin\Setting\Setting');

    Route::get('/category/list-category', '\App\Livewire\Admin\Category\CategoryList');
    Route::get('/category/add-category', '\App\Livewire\Admin\Category\CategoryAdd');
    Route::get('/category/edit-category/{id}', '\App\Livewire\Admin\Category\CategoryEdit')->name('categoryEdit');
    
    Route::get('/product/list-product', '\App\Livewire\Admin\Product\ProductList');
    Route::get('/product/add-product', '\App\Livewire\Admin\Product\ProductAdd');
    Route::get('/product/edit-product/{id}', '\App\Livewire\Admin\Product\ProductEdit')->name('productEdit');

    Route::get('/report', '\App\Livewire\Admin\Report\Report')->name('report');
    Route::get('/history', '\App\Livewire\Admin\History\History')->name('history');

    Route::get('/article/list-article', '\App\Livewire\Admin\Article\ArticleList');
    Route::get('/article/add-article', '\App\Livewire\Admin\Article\ArticleAdd');
    Route::get('/article/edit-article/{id}', '\App\Livewire\Admin\Article\ArticleEdit')->name('articleEdit');
    
    Route::get('/testimonial/list-testimonial', '\App\Livewire\Admin\Testimonial\TestimonialList');
    Route::get('/testimonial/add-testimonial', '\App\Livewire\Admin\Testimonial\TestimonialAdd');
    Route::get('/testimonial/edit-testimonial/{id}', '\App\Livewire\Admin\Testimonial\TestimonialEdit')->name('testimonialEdit');
    
    Route::get('/paymentMethod/list-paymentMethod', '\App\Livewire\Admin\PaymentMethod\PaymentMethodList');
    Route::get('/paymentMethod/add-paymentMethod', '\App\Livewire\Admin\PaymentMethod\PaymentMethodAdd');
    Route::get('/paymentMethod/edit-paymentMethod/{id}', '\App\Livewire\Admin\PaymentMethod\PaymentMethodEdit')->name('paymentMethodEdit');
    
    Route::get('/banner/list-banner', '\App\Livewire\Admin\Banner\BannerList');
    Route::get('/banner/add-banner', '\App\Livewire\Admin\Banner\BannerAdd');
    Route::get('/banner/edit-banner/{id}', '\App\Livewire\Admin\Banner\BannerEdit')->name('bannerEdit');
    
    Route::get('/order/list-order', '\App\Livewire\Admin\Order\OrderList');
    Route::get('/order/edit-order/{id}', '\App\Livewire\Admin\Order\OrderEdit')->name('orderEdit');

    Route::get('/report/pdf', [App\Http\Controllers\Admin\ReportController::class, 'generatePDF'])
    ->name('admin.report.pdf');
    
    Route::get('/report/excel', [App\Http\Controllers\Admin\ReportController::class, 'generateExcel'])
    ->name('admin.report.excel');
});
// user
Route::get('/', '\App\Livewire\User\Home\Home');
Route::get('/product/search/{category?}', '\App\Livewire\User\Search\Search')->name('searchProduct');
Route::get('/detail-product/{id}', '\App\Livewire\User\Product\DetailProduct')->name('detailProductUser');

Route::get('/article', '\App\Livewire\User\Article\ArticleAll');
Route::get('/detail-article/{id}', '\App\Livewire\User\Article\DetailArticle')->name('detailArticleUser');

Route::middleware(['auth'])->group(function () {
    Route::get('/cart-product/{userID}', '\App\Livewire\User\Product\Cart')->name('detailCart');
    Route::get('/checkout/{userID}', '\App\Livewire\User\Product\Checkout')->name('checkoutProduct');
    Route::get('/payment/{orderID}', '\App\Livewire\User\Product\Payment')->name('paymentProduct');
    Route::get('/order/finished', '\App\Livewire\User\Product\PaymentSuccess');

    Route::get('/myorder', '\App\Livewire\User\Order\OrderList');
    Route::get('/myorder/{orderID}', '\App\Livewire\User\Order\OrderDetail')->name('detailMyorder');

    Route::get('/profile', '\App\Livewire\User\Profile\Profile');
    Route::get('/profile/update-data', '\App\Livewire\User\Profile\PersonalData');
    Route::get('/profile/update-password', '\App\Livewire\User\Profile\UpdatePassword');

    Route::get('/wishlist', 'App\Livewire\User\Wishlist\Wishlist');
});