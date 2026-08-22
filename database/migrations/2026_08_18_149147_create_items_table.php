<?php

use App\Models\City\CityFields;
use App\Models\CoreCategory\CoreCategoryFields;
use App\Models\Location\LocationFields;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Item\ItemFields;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(ItemFields::TABLE, function (Blueprint $table) {
            $table->id();
            $table->foreignId(ItemFields::CATEGORY_ID)->constrained(CoreCategoryFields::TABLE)->cascadeOnDelete();
            $table->foreignId(ItemFields::CITY_ID)->constrained(CityFields::TABLE)->cascadeOnDelete();
            $table->foreignId(ItemFields::LOCATION_ID)->constrained(LocationFields::TABLE)->cascadeOnDelete();
            //$table->foreignId(ItemFields::OWNER_ID)->constrained()->cascadeOnDelete();
            $table->text(ItemFields::TITLE);
            $table->string(ItemFields::ADDRESS);
            $table->string(ItemFields::MAP_LINK)->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
