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
        Schema::create('quiz_answer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->references('id')->on('quiz')->onDelete('cascade');
            $table->foreignId('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('question_id')->references('id')->on('quiz')->onDelete('cascade');
            $table->text('answer_text');
            $table->decimal('score', 5, 2);
            $table->dateTime('answered_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_answer');
    }
};
