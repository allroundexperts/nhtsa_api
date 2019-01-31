<?php

namespace App\Http\Interfaces;

Interface Vehicle {
    public function getVehicles($modelYear, $manufacturer, $model);
    public function getCrashRatings($vehicleId);
}