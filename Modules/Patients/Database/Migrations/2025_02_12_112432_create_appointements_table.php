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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
//$table->foreignId('patient_id')->references('id')->on('patients')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('medical_team_id')->references('id')->on('medical_team')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('availability_id')->constrained('availabilities')->onUpdate('cascade')->onDelete('cascade');
            $table->string('description');
            $table->string('status')->default("pending");
            $table->string('ordonnance')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
