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
        Schema::create('benefits_applicants', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->bigInteger('benefit_id');
            $table->string('status')->default('pending');
            $table->date('date_approved')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('benefits_applicants');
    }
};
