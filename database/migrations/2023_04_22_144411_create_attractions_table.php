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
        Schema::create('attractions', function (Blueprint $table) {
          $table->id();
          $table->string('title_compiled')->unique();
          $table->string('title')->unique();
          $table->text('description');
          $table->string('image_path');
          $table->string('site_url')->unique();
          $table->string('qr-code_path');
          $table->unsignedBigInteger('created_by');
          $table->foreign('created_by')->references('id')->on('users');
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attractions');
    }
};
