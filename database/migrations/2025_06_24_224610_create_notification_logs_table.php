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
    Schema::create('notification_logs', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('student_id');
        $table->string('exam_type');
        $table->string('month');
        $table->string('academic_year');
        $table->boolean('sent')->default(false);
        $table->string('sent_via')->nullable(); // e.g., whatsapp, sms
        $table->string('status')->nullable();   // e.g., sent, failed, pending
        $table->timestamps();

    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_logs');
    }
};
