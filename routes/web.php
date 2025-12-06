<?php

use Laravel\Fortify\Features;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\TwoFactor;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');


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
