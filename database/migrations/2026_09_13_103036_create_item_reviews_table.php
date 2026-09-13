<?php

use App\Models\ItemReview\ItemReviewFields;
use App\Models\Item\ItemFields;
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
        Schema::create(ItemReviewFields::TABLE, function (Blueprint $table) {
            $table->id();
            $table->foreignId(ItemReviewFields::ITEM_ID)
                ->constrained(ItemFields::TABLE)
                ->cascadeOnDelete();
            $table->foreignId(ItemReviewFields::SENDER_ID)
                ->constrained('users')
                ->cascadeOnDelete();
            $table->unsignedTinyInteger(ItemReviewFields::STARS)->nullable();
            $table->text(ItemReviewFields::CONTENT);
            $table->boolean(ItemReviewFields::IS_CONFIRMED)->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_reviews');
    }
};
