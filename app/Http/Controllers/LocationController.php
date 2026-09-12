<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\City\CityFields;
use App\Models\Location;
use App\Models\Location\LocationFields;
use App\Services\Location\ListLocationsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function __construct(private readonly ListLocationsService $listLocations)
    {
        //
    }
    public function index(City $city): ?JsonResponse
    {
        return $this->sendResponse([
            'locations' => $this->listLocations->execute([$city->id]),
        ]);
    }
}
