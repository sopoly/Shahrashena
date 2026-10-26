<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemReview\StoreItemReviewRequest;
use App\Http\Requests\ItemReview\UpdateItemReviewRequest;
use App\Models\Item;
use App\Models\ItemReview;
use App\Models\ItemReview\ItemReviewFields;
use Illuminate\Http\JsonResponse;

class ItemReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Item $item): JsonResponse
    {
        return $this->sendResponse([
            'reviews' => $item->reviews()
                ->where(ItemReviewFields::IS_CONFIRMED, true)
                ->with('sender')
                ->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemReviewRequest $request, Item $item): JsonResponse
    {
        $review = $item->reviews()->create([
            ItemReviewFields::SENDER_ID => $request->user()?->getKey(),
            ItemReviewFields::STARS => $request->validated(ItemReviewFields::STARS),
            ItemReviewFields::CONTENT => $request->validated(ItemReviewFields::CONTENT),
            ItemReviewFields::IS_CONFIRMED => false,
        ]);

        return $this->sendResponse([
            'review' => $review->load('sender'),
        ], 'Review created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item, ItemReview $review): JsonResponse
    {
        /*
         * TODO: Item Review list service
         */
        $review = $item->reviews()
            ->whereKey($review->getKey())
            ->where(ItemReviewFields::IS_CONFIRMED, true)
            ->with('sender')
            ->firstOrFail();

        return $this->sendResponse([
            'review' => $review,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemReview $itemReview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemReviewRequest $request, ItemReview $itemReview)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemReview $itemReview)
    {
        //
    }
}
