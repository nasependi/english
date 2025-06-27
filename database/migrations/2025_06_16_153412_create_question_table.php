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
        Schema::create('question', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->references('id')->on('quiz')->onDelete('cascade');
            $table->string('question');
            $table->enum('type', ['pg', 'essay']);
            $table->text('options')->nullable(); // JSON encoded options for multiple choice questions
            $table->text('answer_key')->nullable(); // JSON encoded correct answer(s) for multiple choice questions
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question');
    }
};
