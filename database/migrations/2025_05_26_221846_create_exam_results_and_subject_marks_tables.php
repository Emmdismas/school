<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Table ya exam_results
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->string('class', 10);
            $table->enum('exam_type', ['Midterm', 'Terminal', 'Mock', 'Test']);
            $table->string('academic_year', 10);
            $table->string('month', 20);
            $table->unsignedBigInteger('student_id');
            $table->string('student_name', 100);
            $table->integer('total_marks')->nullable();
            $table->decimal('average_marks', 5, 2)->nullable();
            $table->integer('student_position')->nullable();
            $table->timestamps();

            $table->foreign('school_id')
                  ->references('school_id')
                  ->on('schools')
                  ->onDelete('cascade');
        });

        // Table ya subject_marks
        Schema::create('subject_marks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exam_result_id');
            $table->string('subject_name', 100);
            $table->integer('mark')->unsigned()->check('mark <= 100');
            $table->timestamps();

            $table->foreign('exam_result_id')
                  ->references('id')
                  ->on('exam_results')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('subject_marks');
        Schema::dropIfExists('exam_results');
    }
};
