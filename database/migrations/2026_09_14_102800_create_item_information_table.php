<?php

use App\Models\Item\ItemFields;
use App\Models\ItemInformation\ItemInformationFields;
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
        Schema::create(ItemInformationFields::TABLE, function (Blueprint $table) {
            $table->id();
            $table->foreignId(ItemInformationFields::ITEM_ID)->constrained(ItemFields::TABLE)->cascadeOnDelete();
            $table->string(ItemInformationFields::INFORMATION_SLUG);
            $table->json(ItemInformationFields::INFORMATION_VALUE)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(ItemInformationFields::TABLE);
    }
};
