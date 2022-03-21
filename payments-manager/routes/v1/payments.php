<?php

use App\Http\Controllers\API\V1\PaymentController;

Route::prefix('payments')->name('payments.')->group(function () {
    Route::get('report', [PaymentController::class, 'getPaymentReport'])->name('report');
    Route::apiResource('', PaymentController::class)->parameter('', 'payment');
});
