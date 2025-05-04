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
        Schema::create('form_record', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('second_name');
            $table->string('last_name');
            $table->unsignedBigInteger('school_id'); // Ongeza safu ya school_id
            $table->timestamps();

            // Foreign key constraint kwa school_id
            $table->foreign('school_id')
                  ->references('school_id')
                  ->on('schools')
                  ->onDelete('cascade'); // Futa wanafunzi wote wa shule ikiwa shule imefutwa
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
{
    if (Schema::hasTable('form_record')) {
        Schema::table('form_record', function (Blueprint $table) {
            if (Schema::hasColumn('form_record', 'school_id')) {
                $table->dropForeign(['school_id']);
            }
        });

        Schema::dropIfExists('form_record');
    }
}

};