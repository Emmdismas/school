<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->string('class', 10);
            $table->enum('exam_type', ['Midterm', 'Terminal', 'Mock', 'Test']);
            $table->string('academic_year', 10);
            $table->string('month', 20);
            $table->string('student_id', 20);
            $table->string('student_name', 100);
            $table->integer('subject_1');
            $table->integer('subject_2');
            $table->integer('subject_3');
            $table->integer('subject_4');
            $table->integer('subject_5');
            $table->integer('total_marks')->storedAs('subject_1 + subject_2 + subject_3 + subject_4 + subject_5');
            $table->decimal('average_marks', 5, 2)->storedAs('total_marks / 5');
            $table->integer('student_position')->nullable();
            $table->timestamps();


            // Foreign key constraint kwa school_id
            $table->foreign('school_id')
                  ->references('school_id')
                  ->on('schools')
                  ->onDelete('cascade'); // Futa wanafunzi wote wa shule ikiwa shule imefutwa
        
        });
    }

    public function down()
    {
       
    
            Schema::dropIfExists('exam_results');
        }
    
    
};
