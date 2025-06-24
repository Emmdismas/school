<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_create_school_events_table.php
public function up()
{
    Schema::create('school_events', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('school_id');
        $table->unsignedBigInteger('user_id'); // aliyepakia
        $table->string('event_type'); // emergency, normal, discipline
        $table->string('title');
        $table->text('description')->nullable();
        $table->date('event_date');
        $table->string('school_type')->nullable();
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
    public function down(): void
    {
        Schema::dropIfExists('school_events');
    }
};
