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
        Schema::create('request_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->string('cutoff');
            $table->string('Mon');
            $table->string('Tue');
            $table->string('Wed');
            $table->string('Thu');
            $table->string('Fri');
            $table->string('Sat');
            $table->string('Sun');
            $table->string('status')->default('pending');
            $table->string('reason_to_decline')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_schedules');
    }
};
