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
        Schema::create('homework_table_class_b', function (Blueprint $table) {
            $table->id();
            $table->string('assignment_name');
            $table->text('subject_matter');
            $table->timestamp('uploaded_at')->useCurrent();
            $table->timestamp('deadline')->nullable();
            $table->string('assignment_file')->nullable();
            $table->binary('file_content')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homework_table_class_b');
    }
};
