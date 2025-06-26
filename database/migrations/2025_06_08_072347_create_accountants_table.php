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
        Schema::create('accountants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->string('school_name');
            $table->string('accountant_id')->unique();
            $table->string('full_name');
            $table->string('gender');
            $table->date('date_of_birth');
            $table->string('blood_group');
            $table->string('accountant_email');
            $table->string('phone_number');
            $table->string('address');
            $table->string('city');
            $table->string('district');
            $table->string('nida_number', 20);
            $table->string('role');
            $table->string('username');
            $table->string('password');
            $table->binary('photo')->nullable();
            $table->timestamps();
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accountants');
    }
};
