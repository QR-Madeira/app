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
        Schema::create('site_info', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('footerSede');
            $table->string('footerPhone');
            $table->string('footerMail');
            $table->string('footerCopyright');
            $table->timestamps();
        });
        Schema::create(
            "site_descriptions",
            static function (Blueprint $table) {
                $table->id();
                $table->text("description");
                $table->string("language");
                $table->unique(["language"]);
                $table->unsignedBigInteger("site_id");
                $table->foreign("site_id")
                    ->references("id")
                    ->on("site_info")
                    ->onDelete("cascade");
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_info');
        Schema::dropIfExists('site_descriptions');
    }
};
