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
        Schema::create('reservations', function (Blueprint $table) {              
             $table->id();
             $table->foreignId('user_id')->constrained();
             $table->foreignId('room_id')->constrained();
             $table->foreignId('offer_id')->nullable()->constrained();
             $table->date('check_in_date');
             $table->date('check_out_date');
             $table->integer('number_of_guests');
             $table->decimal('total_amount', 10, 2);
             $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
              $table->softDeletes();
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
