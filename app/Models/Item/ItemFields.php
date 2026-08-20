<?php

namespace App\Models\Item;

use App\Models\FieldsClass;

class ItemFields extends FieldsClass
{
    const TABLE = 'items';

    const ID = 'id';
    const CATEGORY_ID = 'category_id';
    const CITY_ID = 'city_id';
    const LOCATION_ID = 'location_id';
    const OWNER_ID = 'owner_id';
    const TITLE = 'title';
    const ADDRESS = 'address';
    const MAP_LINK = 'map_link';


}
