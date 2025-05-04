<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            // Set engine first
            $table->engine = 'InnoDB';
            
            // Primary key columns
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('school_id');
            
            // Set composite primary key BEFORE any foreign key references
            $table->primary(['student_id', 'school_id']);
            
            // Regular columns
            $table->string('class');
            $table->string('student_name');
            $table->string('gender');
            $table->date('date_of_birth');
            $table->string('blood_group');
            $table->string('parent_name');
            $table->unsignedBigInteger('parent_number');
            $table->string('parent_email');
            $table->string('relationship');
            $table->binary('photo')->nullable();
            $table->integer('year_of_study')->nullable();
            $table->string('status')->default('Active');
            $table->timestamps();

            // Add foreign key constraint AFTER primary key is set
            $table->foreign('school_id')
                  ->references('school_id')
                  ->on('schools')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['school_id']);
            
            // Then drop primary key
            $table->dropPrimary(['student_id', 'school_id']);
        });
        
        Schema::dropIfExists('students');
    }
};