<?php

use App\Models\CoreCategoryFeature\CategoryFeaturefields;
use App\Models\Item\ItemFields;
use App\Models\ItemFeature\ItemFeatureFields;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(ItemFeatureFields::TABLE, function (Blueprint $table) {
            $table->foreignId(ItemFeatureFields::ITEM_ID)
                ->constrained(ItemFields::TABLE)
                ->cascadeOnDelete();
            $table->foreignId(ItemFeatureFields::FEATURE_ID)
                ->constrained(CategoryFeaturefields::TABLE)
                ->cascadeOnDelete();
            $table->json(ItemFeatureFields::FEATURE_VALUE)->nullable();
            $table->unique([
                ItemFeatureFields::ITEM_ID,
                ItemFeatureFields::FEATURE_ID,
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_features');
    }
};
