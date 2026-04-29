<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\MinumanController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\TambahProdukController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\PaymentController;
use App\Models\Mitra;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Middleware\CheckLogin;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SlideshowController;



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [TambahProdukController::class, 'showMenu'])->name('menu');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
Route::get('/auth/redirect-google', [AuthenticatedSessionController::class, 'redirectToGoogle'])->name('redirect.google');
Route::get('/oauthcallback', [AuthenticatedSessionController::class, 'handleGoogleCallback']);

Route::get('/dashboardAdmin', [DashboardAdminController::class, 'index'])->name('dashboardAdmin');
Route::get('/master', [MasterController::class, 'index'])->name('master');



Route::get('pelanggan', [PelangganController::class, 'index'])->name('pelanggan.list')->middleware(CheckLogin::class);

Route::get('cart', [CartController::class, 'cart'])->name('cart');
Route::get('add-to-cart/{id}', [CartController::class, 'addToCart'])->name('add.to.cart');
Route::post('cart/upload-proof', [CartController::class, 'uploadProof'])->name('cart.upload.proof');
Route::delete('remove-from-cart', [CartController::class, 'removeFromCart'])->name('remove.from.cart');
Route::patch('/cart/update', [CartController::class, 'updateCart'])->name('update.cart');

Route::group(['middleware' => ['checkrole:admin']], function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard2');

    Route::get('pelanggan/create', [PelangganController::class, 'create'])->name('pelanggan.create');
    Route::post('pelanggan/store', [PelangganController::class, 'store'])->name('pelanggan.kirim');
    Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');
    Route::get('pelanggan/{id}/edit', [PelangganController::class, 'edit'])->name('pelanggan.edit');
    Route::put('pelanggan/{id}', [PelangganController::class, 'update'])->name('pelanggan.update');

    Route::get('mitra', [MitraController::class, 'index'])->name('mitra.list');
    Route::get('mitra/create', [mitraController::class, 'create'])->name('mitra.create');
    Route::post('mitra/store', [MitraController::class, 'store'])->name('mitra.kirim');
    Route::get('mitra/destroy/{param1}', [MitraController::class, 'destroy'])->name('mitra.destroy');
    Route::get('mitra/edit/{param1}', [MitraController::class, 'edit'])->name('mitra.edit');
    Route::post('mitra/update', [MitraController::class, 'update'])->name('mitra.update');

    Route::get('minuman', [TambahProdukController::class, 'index'])->name('minuman.list');
    Route::get('/minuman/create', [TambahProdukController::class, 'create'])->name('home.create');
    Route::post('/home/store', [TambahProdukController::class, 'store'])->name('home.store');
    // Route for displaying the edit form
    Route::get('minuman/{id}/edit', [TambahProdukController::class, 'edit'])->name('minuman.edit');
    // Route for updating the product (using POST as requested)
    Route::post('minuman/{id}/update', [TambahProdukController::class, 'update'])->name('minuman.update');
    // Route for deleting the product (using POST as requested)
    Route::post('minuman/{id}/destroy', [TambahProdukController::class, 'destroy'])->name('minuman.destroy');

    Route::get('slideshow', [SlideshowController::class, 'index'])->name('slideshow.list');
    Route::get('/slideshow/create', [SlideshowController::class, 'create'])->name('slideshow.create');
    Route::post('/slideshow/store', [SlideshowController::class, 'store'])->name('slideshow.store');
    Route::get('slideshow/{id}/edit', [SlideshowController::class, 'edit'])->name('slideshow.edit');
    Route::post('slideshow/{id}/update', [SlideshowController::class, 'update'])->name('slideshow.update');
    Route::post('slideshow/{id}/destroy', [SlideshowController::class, 'destroy'])->name('slideshow.destroy');

    Route::get('pemesanan', [PaymentController::class, 'orders'])->name('pemesanan.list');
    Route::get('pemesanan/proof/{path}', [PaymentController::class, 'proof'])
        ->where('path', '.*')
        ->name('pemesanan.proof');
    Route::post('pemesanan/{action_id}/accept', [PaymentController::class, 'acceptOrder'])->name('pemesanan.accept');
    Route::post('pemesanan/{action_id}/reject', [PaymentController::class, 'rejectOrder'])->name('pemesanan.reject');
});
// Route untuk guest (belum login)
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// Route untuk user yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route lainnya yang memerlukan autentikasi
    Route::get('/mitra', [MitraController::class, 'index'])->name('mitra.list');
    // ... route lainnya ...

    // Route untuk logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});


Route::post('/payment/pay', [PaymentController::class, 'pay'])->name('payment.pay');
Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');
Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
Route::post('/payment/snap', [PaymentController::class, 'getSnapToken'])->name('payment.snap');
Route::post('/payment/update', [PaymentController::class, 'updatePaymentStatus'])->name('payment.update');
