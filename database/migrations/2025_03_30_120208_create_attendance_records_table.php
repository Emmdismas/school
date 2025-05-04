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
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('student_id');
            $table->string('student_name');
            $table->string('class'); 
            $table->date('attendance_date');
            $table->enum('status', ['Present', 'Absent', 'Not Allowed', 'Sick']);
            $table->integer('total_classes_attended')->default(0);
            $table->integer('total_classes')->default(0);
            $table->float('total_percentage')->default(0);
            $table->timestamps();

            $table->foreign('school_id')
            ->references('school_id')
            ->on('schools')
            ->onDelete('cascade'); // Futa wanafunzi wote wa shule ikiwa shule imefutwa

      // Add foreign key constraint
      $table->foreign('student_id')
            ->references('student_id')
            ->on('students')
            ->onDelete('cascade'); // Cascade on delete to avoid orphaned records
        });
    }

    public function down()
{
    if (Schema::hasTable('attendance_records')) {
        Schema::table('attendance_records', function (Blueprint $table) {
            if (Schema::hasColumn('attendance_records', 'school_id')) {
                $table->dropForeign(['school_id']);
            }
        });

        Schema::dropIfExists('attendance_records');
    }
}

};
