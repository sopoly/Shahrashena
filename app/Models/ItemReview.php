<?php

namespace App\Models;

use App\Models\ItemReview\ItemReviewFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemReview extends Model
{
    /** @use HasFactory<\Database\Factories\ItemReviewFactory> */
    use HasFactory;

    protected $guarded = [];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, ItemReviewFields::ITEM_ID);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, ItemReviewFields::SENDER_ID);
    }
}
