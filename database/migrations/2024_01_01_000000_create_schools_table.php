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
        Schema::create('schools', function (Blueprint $table) {
            $table->string('school_name'); 
            $table->unsignedBigInteger('school_id')->primary(); // Changed from integer
            $table->string('region'); // Mkoa
            $table->string('district'); // Wilaya
            $table->string('school_type'); // Aina ya shule (Primary, Secondary, Advanced)
            $table->unsignedBigInteger('school_fee');
            $table->json('grades'); 
            $table->unsignedBigInteger('number_of_students')->default(0);
            $table->unsignedBigInteger('number_of_teachers')->default(0);
            $table->timestamps(); // Safu za 'created_at' na 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Orodha ya meza zote zinazorejelea 'schools'
        $tables = [
            'students',
            'payment_records',
            'exam_results',
            'attendance_records',
            'assignments',
            'contacts',
            'form_record',
        ];

        // Futa foreign key constraints kwenye meza zote zinazorejelea 'schools'
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropForeign(['school_id']);
                });
            }
        }

        // Sasa futa meza ya 'schools'
        Schema::dropIfExists('schools');
    }
};