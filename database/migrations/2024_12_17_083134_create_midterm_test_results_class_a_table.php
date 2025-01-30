
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
        Schema::create('midterm_test_results_class_a', function (Blueprint $table) {
            $table->id();
            $table->unSignedBigInteger('student_number');
            $table->string('student_name');
            $table->UnSignedBigInteger('subject_1');
            $table->UnSignedBigInteger('subject_2');
            $table->UnSignedBigInteger('subject_3');
            $table->UnSignedBigInteger('subject_4');
            $table->UnSignedBigInteger('subject_5');
            $table->UnSignedBigInteger('total_marks');
            $table->UnSignedBigInteger('average_marks');
            $table->UnSignedBigInteger('student_position')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('midterm_test_results_class_a');
    }
};
