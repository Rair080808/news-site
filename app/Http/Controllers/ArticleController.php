<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Role;
use App\Models\Text;
use App\Models\User;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Главная — все опубликованные статьи, от новых к старым, с пагинацией.
     */
    public function home()
    {
        $texts = Text::with(['user', 'category'])
            ->published()
            ->orderByDesc('created_at')
            ->paginate(6);

        return view('pages.home', [
            'texts' => $texts,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    /**
     * Категория — статьи одной выбранной категории из базы данных.
     * На первом этапе по умолчанию открывается категория «Технологии».
     */
    public function category(?string $slug = null)
    {
        $slug = $slug ?: 'technology';
        $category = Category::where('slug', $slug)->first();

        if (! $category) {
            abort(404);
        }

        $texts = Text::with(['user', 'category'])
            ->published()
            ->where('category_id', $category->id)
            ->orderByDesc('created_at')
            ->paginate(6);

        return view('pages.category', [
            'category' => $category,
            'texts' => $texts,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    /**
     * Журналист — форма создания статьи и список своих статей.
     */
    public function journalist()
    {
        return view('pages.journalist', [
            'categories' => Category::orderBy('name')->get(),
            'myTexts' => Text::with(['category'])
                ->where('user_id', auth()->id())
                ->orderByDesc('created_at')
                ->get(),
        ]);
    }

    /**
     * Сохранение новой статьи в базу данных.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'heading' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'text' => ['required', 'string'],
            'excerpt' => ['nullable', 'string', 'max:500'],
        ], [
            'heading.required' => 'Укажите заголовок статьи.',
            'category_id.required' => 'Выберите категорию.',
            'text.required' => 'Введите текст статьи.',
        ]);

        Text::create([
            'heading' => $data['heading'],
            'category_id' => $data['category_id'],
            'text' => $data['text'],
            'excerpt' => $data['excerpt'] ?? null,
            'is_published' => true, // после сохранения статья публикуется
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('journalist')->with('notice', 'Статья сохранена и опубликована!');
    }

    /**
     * Раздел администратора — управление статьями и ролями пользователей.
     * Доступен только пользователям с ролью admin (см. middleware 'role:admin').
     */
    public function admin()
    {
        return view('pages.admin', [
            'texts' => Text::with(['user', 'category'])->orderByDesc('created_at')->get(),
            'users' => User::with('role')->orderBy('id')->get(),
            'roles' => Role::orderBy('id')->get(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }
}