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
        Schema::create('trip_ticket_locations', function (Blueprint $table) {
            $table->id();
            $table->string('trip_ticket_number');
            $table->string('location');
            $table->string('reason_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_ticket_locations');
    }
};
