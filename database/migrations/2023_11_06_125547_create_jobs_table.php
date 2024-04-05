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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_id')->nullable();
            $table->string('admin_employee_id');
            $table->string('job_title');
            $table->string('job_description', 500);
            $table->string('job_applicants')->nullable();
            $table->string('job_responsibilities', 500);
            $table->string('job_qualifications')->nullable();
            $table->string('hiring_limit')->nullable();
            $table->string('job_department')->nullable();
            $table->string('job_skills_required')->nullable();
            $table->date('hiring_date');
            $table->date('hiring_closing_date');
            $table->string('status')->default('On Going');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
