<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            "attraction_descriptions",
            static function (Blueprint $table) {
                $table->id();
                $table->text("description");
                $table->string("language");
                $table->unsignedBigInteger("attraction_id");
                $table->foreign("attraction_id")
                    ->references("id")
                    ->on("attractions")
                    ->onDelete("cascade");
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists("attraction_descriptions");
    }
};
