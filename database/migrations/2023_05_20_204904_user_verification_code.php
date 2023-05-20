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
        Schema::table("users", static function (Blueprint $table) {
            $table->boolean("active")->default(false);
            $table->string("verification_code")->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("users", static function (Blueprint $table) {
            $table->dropColumn("active");
            $table->dropColumn("verification_code");
        });
    }
};
