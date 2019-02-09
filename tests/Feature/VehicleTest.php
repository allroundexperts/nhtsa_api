<?php

class VehicleTest extends TestCase
{
    public function testGetVehiclesThroughGET()
    {
        $this->json('GET', '/vehicles/2015/Audi/A3', [])
        ->seeJson([
            'Count' => 4
        ]);
    }

    public function testGetVehiclesThroughGETError()
    {
        $this->json('GET', '/vehicles/2015/Audi/A22', [])
        ->seeJson([
            'Count' => 0
        ]);
    }

    public function testGetVehiclesThroughPOST()
    {
        $this->json('POST', '/vehicles', [
            'modelYear' => 2015, 
            'manufacturer' => 'Audi',
            'model' => 'A3'
        ])->seeJson([
            'Count' => 4
        ]);
    }

    public function testGetVehiclesThroughPOSTError()
    {
        $this->json('POST', '/vehicles', [
            'modelYear' => 2015, 
            'manufacturer' => 'Audi',
            'model' => 'A22'
        ])->seeJson([
            'Count' => 0
        ]);
    }
}
