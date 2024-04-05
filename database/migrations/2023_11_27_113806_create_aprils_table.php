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
        Schema::create('aprils', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->string('1')->nullable();
            $table->string('2')->nullable();
            $table->string('3')->nullable();
            $table->string('4')->nullable();
            $table->string('5')->nullable();
            $table->string('6')->nullable();
            $table->string('7')->nullable();
            $table->string('8')->nullable();
            $table->string('9')->nullable();
            $table->string('10')->nullable();
            $table->string('11')->nullable();
            $table->string('12')->nullable();
            $table->string('13')->nullable();
            $table->string('14')->nullable();
            $table->string('15')->nullable();
            $table->string('16')->nullable();
            $table->string('17')->nullable();
            $table->string('18')->nullable();
            $table->string('19')->nullable();
            $table->string('20')->nullable();
            $table->string('21')->nullable();
            $table->string('22')->nullable();
            $table->string('23')->nullable();
            $table->string('24')->nullable();
            $table->string('25')->nullable();
            $table->string('26')->nullable();
            $table->string('27')->nullable();
            $table->string('28')->nullable();
            $table->string('29')->nullable();
            $table->string('30')->nullable();
            $table->integer('year');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aprils');
    }
};
