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
        Schema::create('leave_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constraied()->onDelete('cascade');
            $table->integer('year');
            $table->integer('vacation_total')->default(15);
            $table->integer('vacation_used')->default(0);
            $table->integer('sick_total')->default(15);
            $table->integer('sick_used')->default(0);
            $table->integer('emergency_total')->default(5);
            $table->integer('emergency_used')->default(0);
            $table->timestamps();

            $table->unique(['employee_id', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_balances');
    }
};
