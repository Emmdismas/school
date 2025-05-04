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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->string('class');
            $table->string('assignment_name');
            $table->string('assignment_type');
            $table->text('subject_master');
            $table->timestamp('uploaded_at')->useCurrent();
            $table->timestamp('deadline')->nullable();
            $table->string('assignment_file')->nullable();
            $table->binary('file_content')->nullable(); //store data longBlob
            $table->timestamps();

            $table->foreign('school_id')
                  ->references('school_id')
                  ->on('schools')
                  ->onDelete('cascade'); // Futa wanafunzi wote wa shule ikiwa shule imefutwa
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Futa foreign key constraint kwanza
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
        });

        Schema::dropIfExists('assignments');
    }
};
