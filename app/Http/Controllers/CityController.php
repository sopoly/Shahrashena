<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Services\City\ListCitiesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(ListCitiesService $listCities): JsonResponse
    {
        return $this->sendResponse([
            'cities' => $listCities->execute(),
        ]);
    }
}
