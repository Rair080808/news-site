<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Форма регистрации (логин + пароль + подтверждение пароля).
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Обработка регистрации.
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'login' => ['required', 'string', 'min:3', 'max:50', 'unique:users,login'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ], [
            'login.unique' => 'Пользователь с таким логином уже существует.',
            'password.confirmed' => 'Пароли не совпадают.',
        ]);

        // Пароль хешируется автоматически кастом 'hashed' в модели User.
        // Каждому новому пользователю по умолчанию назначается роль «reader» (читатель).
        $defaultRole = Role::where('name', 'reader')->first();
        $user = User::create([
            'login' => $data['login'],
            'password' => $data['password'],
            'role_id' => $defaultRole ? $defaultRole->id : Role::first()->id,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('notice', 'Регистрация прошла успешно!');
    }

    /**
     * Форма входа (логин + пароль).
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Обработка входа.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt(['login' => $credentials['login'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            return back()->withErrors([
                'login' => 'Неверный логин или пароль.',
            ])->onlyInput('login');
        }

        $request->session()->regenerate();

        return redirect()->route('home')->with('notice', 'Вы вошли в систему. Добро пожаловать!');
    }

    /**
     * Выход из аккаунта.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('notice', 'Вы вышли из аккаунта.');
    }
}