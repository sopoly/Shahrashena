<?php

use App\Models\RefreshToken\RefreshTokenFields;
use App\Models\User\UserFields;
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
        Schema::create(RefreshTokenFields::TABLE, function (Blueprint $table) {
            $table->id();
            $table->foreignId(RefreshTokenFields::USER_ID)->constrained(UserFields::TABLE)->cascadeOnDelete();
            $table->string(RefreshTokenFields::DEVICE_ID)->default('default');
            $table->string(RefreshTokenFields::TOKEN)->unique();
            $table->timestamp(RefreshTokenFields::EXPIRES_AT);
            $table->timestamps();
            $table->unique([RefreshTokenFields::USER_ID, RefreshTokenFields::DEVICE_ID]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(RefreshTokenFields::TABLE);
    }
};
