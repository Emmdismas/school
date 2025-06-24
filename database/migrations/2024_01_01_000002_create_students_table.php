<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            // Single primary key
            $table->id();
            
            // Unique student identifier within school
            $table->unsignedBigInteger('student_id');
            
            // School reference
            $table->unsignedBigInteger('school_id');
            
            // Student details
            $table->string('class');
            $table->string('student_name');
            $table->string('gender');
            $table->date('date_of_birth');
            $table->string('blood_group');
            $table->string('parent_name');
            $table->unsignedBigInteger('parent_number');
            $table->string('parent_email');
            $table->string('relationship');
             $table->string('name');
            $table->string('password');
            $table->integer('year_of_study')->nullable();
            $table->string('status')->default('Active');
            $table->timestamps();

            // Composite unique constraint
            $table->unique(['student_id', 'school_id']);

            // Foreign key to schools
           $table->foreign('school_id', 'fk_students_school_id')
      ->references('school_id')
      ->on('schools')
      ->onDelete('cascade');

        });
        
DB::statement("ALTER TABLE students ADD photo LONGBLOB");
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropUnique(['student_id', 'school_id']);
        });
        
        Schema::dropIfExists('students');
    }
};