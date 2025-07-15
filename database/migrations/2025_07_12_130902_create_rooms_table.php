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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string(('room_type'));
            $table->string('room_number')->unique();
            $table->decimal('price_per_night', 10, 2);
            $table->integer('capacity');
            $table->text('description')->nullable();
            $table->string('imagePath')->nullable();
            $table->boolean('available')->default(true); 
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
