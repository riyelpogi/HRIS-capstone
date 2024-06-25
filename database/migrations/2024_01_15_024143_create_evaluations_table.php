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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('evaluation_question_id');
            $table->string('evaluated');
            $table->string('evaluator');
            $table->integer('qone');
            $table->integer('qtwo');
            $table->integer('qthree');
            $table->integer('qfour');
            $table->integer('qfive');
            $table->integer('qsix');
            $table->integer('qseven');
            $table->integer('qeight');
            $table->integer('qnine');
            $table->integer('qten');
            $table->integer('total');
            $table->string('recommendation', 500);
            $table->integer('month');
            $table->integer('year');
            $table->string('grade')->nullable();
            $table->string('dep_employee')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
