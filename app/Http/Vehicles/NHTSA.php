<?php
namespace App\Http\Vehicles;

use App\Http\Interfaces\Vehicle;
use GuzzleHttp\Client;

class NHTSA implements Vehicle {

    protected $client;

    public function __construct(Client $client){
        $this->client = $client;
    }
    
    public function getVehicles($modelYear, $manufacturer, $model, $crashRatings = false){
        $count = 0;
        $dataArray = [];
        $response = $this->client->get("https://one.nhtsa.gov/webapi/api/SafetyRatings/modelyear/{$modelYear}/make/{$manufacturer}/model/{$model}?format=json");
        if($response->getReasonPhrase() === 'OK'){
            $data = json_decode($response->getBody());
            $count = $data->Count;
            if($count > 0){
                foreach($data->Results as $result){
                    $formattedResult = [];
                    $formattedResult['Description'] = $result->VehicleDescription;
                    $formattedResult['VehicleId'] = $result->VehicleId;
                    $crashRatings !== false && $crashRatings !== "false" ?
                        $formattedResult['CrashRating'] = $this->getCrashRatings($result->VehicleId):
                        null;
                    $dataArray[] = $formattedResult;
                }
            }
        }
        return ['Count' => $count, 'Results' => $dataArray];
    }

    public function getCrashRatings($vehicleId){
        $rating = false;
        $response = $this->client->get("https://one.nhtsa.gov/webapi/api/SafetyRatings/VehicleId/$vehicleId?format=json");
        if($response->getReasonPhrase() === 'OK'){
            $data = json_decode($response->getBody());
            $data->Count > 0 ? $rating = $data->Results[0]->OverallRating: null;
        }
        return $rating;
    }
}
