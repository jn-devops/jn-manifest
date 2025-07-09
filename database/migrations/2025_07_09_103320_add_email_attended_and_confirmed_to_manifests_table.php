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
        Schema::table('manifests', function (Blueprint $table) {
            $table->string('email')->nullable();
            $table->boolean('attended')->default(false)->nullable();
            $table->boolean('confirmed')->default(false)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('manifests', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('attended');
            $table->dropColumn('confirmed');
        });
    }
};
