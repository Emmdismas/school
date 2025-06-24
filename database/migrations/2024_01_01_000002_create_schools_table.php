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
        Schema::create('schools', function (Blueprint $table) {
            $table->unsignedBigInteger('school_id')->primary();
            $table->string('school_name'); 
            $table->string('region');
            $table->string('district');
            $table->string('school_type');
            $table->json('fees_structure'); // New field for fees structure
            $table->json('grades');
            $table->json('subjects')->nullable();
            $table->unsignedBigInteger('number_of_students')->default(0);
            $table->unsignedBigInteger('number_of_teachers')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $tables = [
            'students',
            'payment_records',
            'exam_results',
            'attendance_records',
            'assignments',
            'contacts',
            'form_record',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropForeign(['school_id']);
                });
            }
        }

        Schema::dropIfExists('schools');
    }
};
