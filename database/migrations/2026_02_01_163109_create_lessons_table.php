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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('courses')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('title');
            $table->text('content'); // Text or Video URL
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
