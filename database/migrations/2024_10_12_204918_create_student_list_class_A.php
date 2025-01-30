<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('student_list_class_A', function (Blueprint $table) {
            $table->engine = 'InnoDB';
           // $table->id();
            $table->unsignedBigInteger('student_number')->primary(); // Make it unsignedBigInteger and set it as primary key
            $table->string('student_name');
            $table->string('gender');
            $table->date('date_of_birth');
            $table->string('blood_group');
            $table->string('parent_name');
            $table->unsignedBigInteger('parent_number');
            $table->string('parent_email');
            $table->string('relationship');
            $table->string('photo_path'); // For the photo upload
            $table->timestamps();
        });
    }


    //php artisan make:migration create_student_list_class_c


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_list_class_a');
    }
};
