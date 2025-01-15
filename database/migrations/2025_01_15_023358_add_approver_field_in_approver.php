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
        Schema::table('approvers', function (Blueprint $table) {
            $table->string('approver_type')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('unit')->nullable()->change();
            $table->string('type')->nullable()->change();
            $table->string('department')->nullable()->change();
            $table->string('cost_center')->nullable()->change();
            $table->string('budget_line_charging_1')->nullable()->change();
            $table->integer('gl_account')->nullable()->change();
            $table->string('budget_line_charging_2')->nullable()->change();
            $table->string('product')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('approvers', function (Blueprint $table) {
            $table->dropColumn('approver_type');
            $table->dropColumn('name');
            $table->dropColumn('email');
        });
    }
};
