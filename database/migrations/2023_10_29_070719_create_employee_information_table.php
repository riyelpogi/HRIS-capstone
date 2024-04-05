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
        Schema::create('employee_information', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->nullable();
            $table->date('birthday')->nullable();
            $table->integer('age')->nullable();
            $table->string('address')->nullable();
            $table->string('province', 500)->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('barangay', 500)->nullable();
            $table->string('region', 500)->nullable();

            $table->string('country')->default('Philippines');

            $table->string('mobile_number')->nullable();
            $table->string('resume')->nullable();
            $table->date('date_hired')->nullable();
            $table->date('date_regular')->nullable();
            $table->date('deployment_date')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_information');
    }
};
