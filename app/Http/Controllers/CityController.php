<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Services\City\ListCitiesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct(private readonly ListCitiesService $listCities)
    {

    }
    public function index(): JsonResponse
    {
        return $this->sendResponse([
            'cities' => $this->listCities->execute(),
        ]);
    }
    public function show(City $city): JsonResponse
    {
        return $this->sendResponse([
            'city' => $city,
        ]);
    }
}
