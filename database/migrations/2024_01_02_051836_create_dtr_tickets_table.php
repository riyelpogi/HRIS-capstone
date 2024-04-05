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
        Schema::create('dtr_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->date('date');
            $table->time('time');
            $table->string('inorout');
            $table->string('file_name');
            $table->string('status')->default('pending');
            $table->string('reason_to_decline', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dtr_tickets');
    }
};
