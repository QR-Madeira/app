<?php

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
        Schema::table("attractions_close_locations", static function (Blueprint $table) {
            $table->double("lat", 16, 14)->nullable();
            $table->double("lon", 17, 14)->nullable();
            $table->dropColumn("location");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("attractions_close_locations", static function (Blueprint $table) {
            $table->dropColumn("lat");
            $table->dropColumn("lon");
            $table->string('location');
        });
    }
};
