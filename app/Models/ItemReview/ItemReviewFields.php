<?php

namespace App\Models\ItemReview;

use App\Models\FieldsClass;

class ItemReviewFields extends FieldsClass
{
    const string TABLE = 'item_reviews';

    const string ID           = 'id';
    const string ITEM_ID      = 'item_id';
    const string SENDER_ID    = 'sender_id';
    const string STARS        = 'stars';
    const string CONTENT      = 'content';
    const string IS_CONFIRMED = 'is_confirmed';
}
