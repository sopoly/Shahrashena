<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\CoreCategory\CoreCategoryFields;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(CoreCategoryFields::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(CoreCategoryFields::SLUG);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('core_categories');
    }
};
