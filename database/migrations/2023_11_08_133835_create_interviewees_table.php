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
        Schema::create('interviewees', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('job_id');
            $table->date('date');
            $table->string('time');
            $table->string('interview_type')->nullable();
            $table->string('status')->nullable();
            $table->bigInteger('application_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interviewees');
    }
};
