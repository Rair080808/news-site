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
        // Основная рабочая таблица — тексты (статьи).
        Schema::create('texts', function (Blueprint $table) {
            $table->id();
            $table->string('heading');                             // заголовок статьи
            $table->text('text');                                 // раздел с текстом статьи
            $table->string('excerpt')->nullable();                // краткая аннотация (доп.)
            $table->boolean('is_published')->default(true);       // опубликована ли
            // Внешний ключ на категорию: обязателен.
            // Удаление категории с текстами запрещено (restrict).
            $table->foreignId('category_id')
                ->constrained('categories')
                ->restrictOnDelete();
            // Внешний ключ на автора: обязателен.
            // Удаление пользователя каскадно удаляет его тексты (cascade).
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->timestamps();                                 // created_at, updated_at

            // Индексируем внешние ключи (требование: FK проиндексированы)
            $table->index('category_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('texts');
    }
};