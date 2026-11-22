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
        // Справочник ролей (родительская таблица для users, связь 1-ко-многим).
        // Создаётся здесь первой, чтобы таблица users могла ссылаться на неё внешним ключом.
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();      // название роли (уникальное)
            $table->timestamps();
        });

        // Учётные записи пользователей.
        // Авторизация выполняется только по логину и паролю.
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('login')->unique();      // уникальный логин (уникальный индекс)
            $table->string('password');             // пароль хранится в хешированном виде
            // Внешний ключ на роли: обязателен.
            // Удаление роли, назначенной пользователю, запрещено (restrict).
            $table->foreignId('role_id')
                ->constrained('roles')
                ->restrictOnDelete();
            $table->rememberToken();
            $table->timestamps();

            // Индексируем внешний ключ role_id (требование: FK проиндексированы)
            $table->index('role_id');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('login')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
    }
};