<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Разделы сайта и доступ по ролям (Middleware):
|  - Главная     — доступна всем (включая неавторизованных)
|  - Категория   — доступна всем
|  - Журналист   — доступна журналистам и администраторам (role:journalist,admin)
|  - Админ       — доступна только администраторам (role:admin)
|
| В Laravel 11 middleware 'role' зарегистрирован в bootstrap/app.php
| (alias -> App\Http\Middleware\CheckRole).
|
| Шапка и подвал вынесены в отдельные компоненты (components/header.blade.php
| и components/footer.blade.php), подключаются на каждой странице.
|
*/

// Публичные разделы (доступны всем)
Route::get('/', [ArticleController::class, 'home'])->name('home');
Route::get('/category/{slug?}', [ArticleController::class, 'category'])->name('category');

// Регистрация и вход
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

// Выход из аккаунта
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Раздел журналиста — только журналистам и администраторам
Route::middleware(['auth', 'role:journalist,admin'])->group(function () {
    Route::get('/journalist', [ArticleController::class, 'journalist'])->name('journalist');
    Route::post('/journalist', [ArticleController::class, 'store'])->name('journalist.store');
});

// Раздел администратора — только администраторам
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [ArticleController::class, 'admin'])->name('admin');
});