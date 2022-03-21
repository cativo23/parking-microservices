<?php

use App\Http\Controllers\API\V1\RegistrationController;

Route::prefix('registrations')->name('registrations.')->group(function () {
    Route::get('/by-type', [RegistrationController::class, 'getResidentRegistrations'])->name('by-type');
    Route::apiResource('', RegistrationController::class)->parameter('', 'registrations');
});
