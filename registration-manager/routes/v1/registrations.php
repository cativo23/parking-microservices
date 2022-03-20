<?php

use App\Http\Controllers\API\V1\RegistrationController;

Route::prefix('registrations')->name('registrations.')->group(function () {
    Route::apiResource('', RegistrationController::class)->parameter('', 'registrations');
});