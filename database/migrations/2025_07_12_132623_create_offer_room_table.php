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
        Schema::create('offer_room', function (Blueprint $table) {
              $table->id();
              $table->foreignId('offer_id')->onDelete('cascade');
              $table->foreignId('room_id')->onDelete('cascade');
              $table->softDeletes();
              $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_room');
    }
};
