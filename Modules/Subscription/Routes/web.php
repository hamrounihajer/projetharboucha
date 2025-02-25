<?php
use Modules\Subscription\Http\Controllers\planControler;
use Modules\Subscription\Http\Controllers\SubscriptionControler;

 // Routes pour les plans
 Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
 Route::get('/plans/create', [PlanController::class, 'create'])->name('plans.create');
 Route::post('/plans', [PlanController::class, 'store'])->name('plans.store');
 Route::get('/plans/{plan}', [PlanController::class, 'show'])->name('plans.show');
 Route::get('/plans/{plan}/edit', [PlanController::class, 'edit'])->name('plans.edit');
 Route::put('/plans/{plan}', [PlanController::class, 'update'])->name('plans.update');  // Ajoutez cette route si vous n'en avez pas pour les mises à jour
 Route::delete('/plans/{plan}', [PlanController::class, 'destroy'])->name('plans.destroy');


Route::prefix('subscription')->group(function() {
    Route::get('/', 'SubscriptionController@index');
});
//Routes pour les abonnements :
Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');

