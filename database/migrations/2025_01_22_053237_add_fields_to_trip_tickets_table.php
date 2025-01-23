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
        Schema::table('trip_tickets', function (Blueprint $table) {
            $table->string('request_for_payment_number')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('drop_off_point')->nullable();
            $table->string('pick_up_point')->nullable();
            $table->string('charge_to')->nullable();
            $table->string('provider_code')->nullable();
            $table->json('attachments')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trip_tickets', function (Blueprint $table) {
           $table->dropColumn('request_for_payment_number');
           $table->dropColumn('invoice_number');
           $table->dropColumn('drop_off_point');
           $table->dropColumn('pick_up_point');
           $table->dropColumn('charge_to');
           $table->dropColumn('provider_code');
           $table->dropColumn('attachments');
        });
    }
};
