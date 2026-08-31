<?php

use App\Models\CoreCategory\CoreCategoryFields;
use App\Models\CoreCategoryFeature\CategoryFeatureFields;
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
        Schema::create(CategoryFeatureFields::TABLE, function (Blueprint $table) {
            $table->id();
            $table->foreignId(CategoryFeatureFields::CATEGORY_ID)->constrained(CoreCategoryFields::TABLE)->cascadeOnDelete();
            $table->text(CategoryFeatureFields::TITLE);
            $table->string(CategoryFeatureFields::TYPE);
            $table->json(CategoryFeatureFields::AVAILABLE_CHOICES)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('core_category_features');
    }
};
