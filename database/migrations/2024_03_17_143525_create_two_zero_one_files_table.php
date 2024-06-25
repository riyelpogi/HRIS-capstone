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
        Schema::create('two_zero_one_files', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->string('sss', 1000)->nullable();
            $table->string('tin', 1000)->nullable();
            $table->string('philhealth', 1000)->nullable();
            $table->string('nbi', 1000)->nullable();
            $table->string('diploma', 1000)->nullable();
            $table->string('tor', 1000)->nullable();
            $table->string('resume', 1000)->nullable();
            $table->string('employment_contracts', 1000)->nullable();
            $table->string('others', 5000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('two_zero_one_files');
    }
};
