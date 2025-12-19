<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

use App\Http\Controllers\{
    FrontendController,
    CartController,
    CheckoutController,
    OrderController,
    PaymentController,
    PinController
};

use App\Http\Controllers\Admin\{
    DashboardController,
    ProductController,
    CategoryController,
    OrderController as AdminOrder
};

use App\Livewire\Settings\{
    Profile,
    Password,
    TwoFactor,
    Appearance
};

/*
|--------------------------------------------------------------------------
| PUBLIC (BOLEH DIAKSES SEMUA)
|--------------------------------------------------------------------------
*/
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/shop', [FrontendController::class, 'shop'])->name('shop');
Route::get('/product/{product}', [FrontendController::class, 'product'])->name('product.show');

/*
|--------------------------------------------------------------------------
| PAYMENT CALLBACK
|--------------------------------------------------------------------------
*/
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/pending', [PaymentController::class, 'pending'])->name('payment.pending');
Route::get('/payment/failed', [PaymentController::class, 'failed'])->name('payment.failed');

/*
|--------------------------------------------------------------------------
| SET PIN (LOGIN REQUIRED, TANPA CHECK_PIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/set-pin', [PinController::class, 'store'])->name('pin.store');
});

/*
|--------------------------------------------------------------------------
| USER LOGIN + WAJIB CHECK PIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'check_pin'])->group(function () {

    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

/*
|--------------------------------------------------------------------------
| ADMIN (TIDAK WAJIB PIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('products', ProductController::class)->except(['show']);
        Route::resource('categories', CategoryController::class)->except(['show']);

        Route::resource('orders', AdminOrder::class)
            ->only(['index', 'show', 'update']);
    });

/*
|--------------------------------------------------------------------------
| USER SETTINGS (JETSTREAM)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::redirect('/settings', '/settings/profile');

    Route::get('/settings/profile', Profile::class)->name('profile.edit');
    Route::get('/settings/password', Password::class)->name('user-password.edit');
    Route::get('/settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('/settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                && Features::optionEnabled(
                    Features::twoFactorAuthentication(),
                    'confirmPassword'
                ),
                ['password.confirm'],
                []
            )
        )
        ->name('two-factor.show');
});
