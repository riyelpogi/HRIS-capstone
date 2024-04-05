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
        Schema::create('request_offs', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->date('date');
            $table->string('reason', 255);
            $table->string('status')->default('pending');
            $table->string('reason_to_decline')->nullable();
            $table->date('rest_day');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_offs');
    }
};
