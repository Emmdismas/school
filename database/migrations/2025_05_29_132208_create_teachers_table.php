<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('school_id');
    $table->string('school_name');
    $table->string('teacher_id')->unique();
    $table->string('full_name');
    $table->string('gender');
    $table->date('date_of_birth');
    $table->string('blood_group');
    $table->string('teacher_email');
    $table->string('phone_number');
    $table->string('nida_number', 20);
    $table->string('city');
    $table->string('district');
    $table->string('address');
    $table->string('username');
    $table->string('password');
    $table->json('subjects')->nullable();
    $table->json('classes')->nullable();  
    $table->string('role');
    $table->boolean('is_class_teacher')->default(false);
    $table->string('class_incharge')->nullable();
    $table->binary('photo')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
