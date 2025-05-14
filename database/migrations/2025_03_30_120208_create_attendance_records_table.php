<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            
            // School and student references
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('student_id');
            
            // Student info (redundant but useful for reporting)
            $table->string('student_name');
            $table->string('class'); 
            
            // Attendance data
            $table->date('attendance_date');
            $table->enum('status', ['Present', 'Absent', 'Not Allowed', 'Sick']);
            $table->integer('total_classes_attended')->default(0);
            $table->integer('total_classes')->default(0);
            $table->float('total_percentage')->default(0);
            $table->timestamps();

            // Composite foreign key to students with explicit name
            $table->foreign(['student_id', 'school_id'], 'fk_attendance_student_school')
                  ->references(['student_id', 'school_id'])
                  ->on('students')
                  ->onDelete('cascade');

            // Additional foreign key to schools with explicit name
            $table->foreign('school_id', 'fk_attendance_school')
                  ->references('school_id')
                  ->on('schools')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('attendance_records', function (Blueprint $table) {
            // Drop foreign keys using explicit names
            $table->dropForeign('fk_attendance_student_school');
            $table->dropForeign('fk_attendance_school');
        });
        
        Schema::dropIfExists('attendance_records');
    }
};