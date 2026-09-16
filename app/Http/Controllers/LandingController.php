<?php

namespace App\Http\Controllers;

use App\Models\CoreCategory;
use App\Models\Item;
use App\Services\Item\GetItemFilterFieldsService;
use App\Services\Item\ListItemsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function getItems(Request $request, ListItemsService $listItem, CoreCategory $category): JsonResponse
    {
        return $this->sendResponse([
            'items' => $listItem->execute($category, $request->collect()),
        ]);
    }

    public function getSingleItem(Item $item): JsonResponse
    {
        return $this->sendResponse([
            'item' => $item,
        ]);
    }

    public function getFieldsToFilterItems(Request $request, GetItemFilterFieldsService $getItemFilterFields): JsonResponse
    {
        return $this->sendResponse(
            $getItemFilterFields->execute($request->collect())
        );
    }
}
