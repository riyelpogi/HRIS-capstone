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
        Schema::create('evaluation_questions', function (Blueprint $table) {
            $table->id();
            $table->string('qone', 1000)->nullable();
            $table->string('qtwo', 1000)->nullable();
            $table->string('qthree', 1000)->nullable();
            $table->string('qfour', 1000)->nullable();
            $table->string('qfive', 1000)->nullable();
            $table->string('qsix', 1000)->nullable();
            $table->string('qseven', 1000)->nullable();
            $table->string('qeight', 1000)->nullable();
            $table->string('qnine', 1000)->nullable();
            $table->string('qten', 1000)->nullable();
            $table->integer('month');
            $table->integer('year');
            $table->string('status')->default('open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_questions');
    }
};
