<?php

namespace App\Models\CoreCategoryFeature;

use App\Models\FieldsClass;

class CategoryFeaturefields extends FieldsClass
{
    const TABLE = 'core_category_features';

    const ID = 'id';
    const CATEGORY_ID = 'category_id';
    const TITLE = 'title';
    const TYPE = 'type';
    const AVAILABLE_CHOICES = 'available_choices';
}
