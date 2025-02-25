<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\TaxRulesController;

Route::middleware(['auth'])->group(function () {
    
    // 📦 ROUTES CHECKOUT
    Route::get('/checkout/{orderId}', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/confirm', [CheckoutController::class, 'confirm'])->name('checkout.confirm');

    // 💳 ROUTES PAYMENT
    Route::get('/payment/{orderId}', [PaymentController::class, 'showPaymentForm'])->name('payment.show');
    Route::post('/payment/store', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/failure', [PaymentController::class, 'failure'])->name('payment.failure');

    // 🏛 ROUTES TAXES
    Route::get('/taxes', [TaxController::class, 'index'])->name('taxes.index');
    Route::get('/taxes/create', [TaxController::class, 'create'])->name('taxes.create');
    Route::post('/taxes/store', [TaxController::class, 'store'])->name('taxes.store');
    Route::get('/taxes/{id}/edit', [TaxController::class, 'edit'])->name('taxes.edit');
    Route::put('/taxes/{id}', [TaxController::class, 'update'])->name('taxes.update');
    Route::delete('/taxes/{id}', [TaxController::class, 'destroy'])->name('taxes.destroy');

    // 📜 ROUTES TAX RULES
    Route::get('/tax-rules', [TaxRuleController::class, 'index'])->name('taxrules.index');
    Route::get('/tax-rules/create', [TaxRuleController::class, 'create'])->name('taxrules.create');
    Route::post('/tax-rules/store', [TaxRuleController::class, 'store'])->name('taxrules.store');
    Route::get('/tax-rules/{id}/edit', [TaxRuleController::class, 'edit'])->name('taxrules.edit');
    Route::put('/tax-rules/{id}', [TaxRuleController::class, 'update'])->name('taxrules.update');
    Route::delete('/tax-rules/{id}', [TaxRuleController::class, 'destroy'])->name('taxrules.destroy');
});

