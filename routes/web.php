<?php

use Laravel\Fortify\Features;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\TwoFactor;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PinController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CartController;

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;

// Home page
Route::get('/', [FrontendController::class, 'home'])->name("home");
Route::get('/shop', [FrontendController::class, 'shop'])->name("shop");
Route::get('/product/{product}', [FrontendController::class, 'product'])->name("product.show");
Route::middleware('auth')->post('/set-pin', [PinController::class, 'store'])->name('pin.store');

Route::middleware('auth')->group(function () {

    Route::get('/cart', action: [CartController::class, 'index'])->name('cart');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::view('/checkout', 'frontend.pages.checkout')->name("checkout");

    Route::post('/set-pin', [PinController::class, 'store'])
        ->name('pin.store');
});


// ADMIN DASHBOARD (khusus admin)
Route::middleware(['auth', 'is_admin'])
    ->as('admin.')

    ->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');



        Route::get('products', [ProductController::class, 'index'])->name('products.index');
        Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('products', [ProductController::class, 'store'])->name('products.store');
        Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

        Route::delete(
            'admin/products/{product}/image/{image}',
            [ProductController::class, 'deleteImage']
        )->name('products.image.delete');


        Route::resource('categories', CategoryController::class)->except(['show']);


    });



Route::middleware(['check_pin'])->group(function () {
    Route::get('/', [FrontendController::class, 'home'])->name("home");
    Route::get('/shop', action: [FrontendController::class, 'shop'])->name("shop");
    Route::get('/cart', action: [CartController::class, 'index'])->name('cart');

});

// MATIKAN /dashboard untuk user biasa
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'is_admin']) // hanya admin yang boleh
    ->name('dashboard');


// USER SETTINGS (Jetstream)
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
