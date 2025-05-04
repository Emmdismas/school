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
        Schema::create('payment_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('student_id');
            $table->string('student_name');
            $table->string('class'); 
            $table->string('payment_type');
            $table->integer('amount');
            $table->binary('receipt_content')->nullable(); // Hifadhi receipt kama longBlob
            $table->string('receipt_filename')->nullable(); // Hifadhi jina la receipt
            $table->timestamps();
        
            $table->foreign('school_id')
                  ->references('school_id')
                  ->on('schools')
                  ->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Futa foreign key constraint kwanza
       
        Schema::dropIfExists('payment_records');
    }
};
