<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('attendance_table_class_a', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('student_number');
            $table->string('student_name'); // Safu ya jina la mwanafunzi
            $table->date('attendance_date');
            $table->enum('status', ['Present', 'Absent', 'Not Allowed', 'Sick']);
            $table->integer('total_classes_attended')->default(0);
            $table->integer('total_classes')->default(0);
            $table->float('total_percentage')->default(0);
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('student_number')
                  ->references('student_number')
                  ->on('student_list_class_a')
                  ->onDelete('cascade'); // Cascade on delete to avoid orphaned records
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('attendance_table_class_a');
    }
};
