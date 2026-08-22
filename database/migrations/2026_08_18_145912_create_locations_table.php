<?php

use App\Models\City\CityFields;
use App\Models\Location\LocationFields;
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
        Schema::create(LocationFields::TABLE, function (Blueprint $table) {
            $table->id();
            $table->foreignId(LocationFields::CITY_ID)->constrained(CityFields::TABLE)->cascadeOnDelete();
            $table->text(LocationFields::TITLE);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
