<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User\UserFields;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(UserFields::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(UserFields::NAME)->nullable();
            $table->string(UserFields::EMAIL)->unique();
            $table->string(UserFields::PASSWORD)->nullable();
            $table->timestamp(UserFields::EMAIL_VERIFIED_AT)->nullable();
            $table->string(UserFields::PHONE_NUMBER)->nullable();
            $table->string(UserFields::OTP_CODE)->nullable();
            $table->dateTime(UserFields::OTP_EXPIRE_AT)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
