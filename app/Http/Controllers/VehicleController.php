<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Interfaces\Vehicle;

class VehicleController extends Controller
{
    protected $request, $vehicle;

    public function __construct(Request $request, Vehicle $vehicle){
        $this->request = $request;
        $this->vehicle = $vehicle;
    }

    public function getVehiclesThroughGET($modelYear, $manufacturer, $model){

        $data = $this->vehicle->getVehicles(
            $modelYear, 
            $manufacturer, 
            $model, 
            $this->request->query('withRating', false)
        );
        return response()->json($data);
    }

    public function getVehiclesThroughPOST(){
        
        $this->validate($this->request, [
            'modelYear' => 'required',
            'manufacturer' => 'required',
            'model' => 'required',
        ]);

        $data = $this->vehicle->getVehicles(
            $this->request->input('modelYear'), 
            $this->request->input('manufacturer'), 
            $this->request->input('model'), 
            $this->request->query('withRating', false)
        );
        return response()->json($data);
    }

}
