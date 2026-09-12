<?php

namespace App\Http\Controllers;

use App\Services\CoreCategory\ListCategoriesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CoreCategoryController extends Controller
{
    public function index(ListCategoriesService $listCategories): JsonResponse
    {
        return $this->sendResponse([
            'categories' => $listCategories->execute(),
        ]);
    }
}
