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
        Schema::create('inand_outs', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->integer('year');
            $table->integer('month');
            $table->integer('date');
            $table->string('time');
            $table->string('inorout');
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inand_outs');
    }
};
