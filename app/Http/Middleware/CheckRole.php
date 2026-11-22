<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Проверяет, что у текущего пользователя есть одна из указанных ролей.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  допустимые роли (например, 'admin', 'journalist')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Если не авторизован — перенаправим на страницу входа
        if (! $request->user()) {
            return redirect()->route('login');
        }

        // Получаем имя роли текущего пользователя из таблицы roles
        $userRole = $request->user()->role?->name;

        // Если роль пользователя не входит в список разрешённых — 403
        if (! in_array($userRole, $roles, true)) {
            abort(403, 'У вас нет доступа к этому разделу.');
        }

        return $next($request);
    }
}