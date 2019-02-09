<?php
use App\Http\Vehicles\NHTSA;
use GuzzleHttp\Client;

class VehicleUnitTest extends TestCase
{
    protected $vehicle;

    public function setUp(){
        $this->vehicle = new NHTSA(new Client());
    }

    public function testGetVehicles()
    {
       $result = $this->vehicle->getVehicles(2015, 'Audi', 'A3');
       $this->assertEquals($result['Count'], 4);
    }

    public function testGetVehiclesError()
    {
        $result = $this->vehicle->getVehicles(2015, 'Audi', 'A22');
        $this->assertEquals($result['Count'], 0);
    }

    public function testCrashRatings()
    {
        $result = $this->vehicle->getCrashRatings(9403);
        $this->assertNotEquals($result, false);
    }

    public function testCrashRatingsError()
    {
        $result = $this->vehicle->getCrashRatings(1122232221);
        $this->assertFalse($result);
    }
}
