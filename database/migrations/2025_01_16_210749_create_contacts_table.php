<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->string('name');
            $table->string('email');
            $table->text('message');
            $table->timestamps();
            $table->foreign('school_id')
                  ->references('school_id')
                  ->on('schools')
                  ->onDelete('cascade'); // Futa wanafunzi wote wa shule ikiwa shule imefutwa
        });
    }

    public function down()
    {
        if (Schema::hasTable('contacts')) {
            Schema::table('contacts', function (Blueprint $table) {
                if (Schema::hasColumn('contacts', 'school_id')) {
                    $table->dropForeign(['school_id']);
                }
            });
    
            Schema::dropIfExists('contacts');
        }
    }
    
};
