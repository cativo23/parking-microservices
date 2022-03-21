<?php

use App\Http\Controllers\API\V1\VehicleController;

Route::prefix('vehicles')->name('units.')->group(function () {
    Route::get('all', [VehicleController::class, 'getAllByType']);
    Route::apiResource('', VehicleController::class)->parameter('', 'vehicle');
});
