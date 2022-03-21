<?php

use App\Http\Controllers\API\V1\RegistrationController;

Route::prefix('registrations')->middleware('auth:api')->name('registrations.')->group(function () {
    Route::put('/month-start', [RegistrationController::class, 'monthStart'])->name('month-start');
    Route::get('/by-type', [RegistrationController::class, 'getResidentRegistrations'])->name('by-type');
    Route::put('{registration}/restore', [RegistrationController::class, 'restore'])->name('restore');
    Route::apiResource('', RegistrationController::class)->parameter('', 'registrations');
});
