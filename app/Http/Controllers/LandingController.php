<?php

namespace App\Http\Controllers;

use App\Classes\Item\ItemFilterFields;
use App\Classes\Item\ItemList;
use App\Models\Item;
use App\Models\Item\ItemFields;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function getItems(Request $request): JsonResponse
    {
        $items = new ItemList($request->collect());
        $itemList = [
            'items' => $items->getItems()
        ];
        return $this->sendResponse($itemList);
    }

    public function getSingleItem(Item $item): JsonResponse
    {
        return $this->sendResponse([
            'item' => $item,
        ]);
    }

    public function getFieldsToFilterItems(Request $request): JsonResponse
    {
        $itemFilterFields = new ItemFilterFields($request->collect());
        $finalFields = [
            'cities' => $itemFilterFields->getCities(),
            'locations' => $itemFilterFields->getLocations(),
            'features' => $itemFilterFields->getFeatures(),
        ];
        return $this->sendResponse($finalFields);
    }
}
