<?php

use App\Models\Item\ItemFields;
use App\Models\ItemSocialAccount\SocialAccountFields;
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
        Schema::create(SocialAccountFields::TABLE, function (Blueprint $table) {
            $table->id();
            $table->foreignId(SocialAccountFields::ITEM_ID)->constrained(ItemFields::TABLE)->cascadeOnDelete();
            $table->string(SocialAccountFields::SOCIAL_SLUG);
            $table->string(SocialAccountFields::ACCOUNT_ID);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_social_accounts');
    }
};
