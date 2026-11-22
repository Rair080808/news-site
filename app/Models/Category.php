<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Тексты, принадлежащие категории (родительская таблица, 1-ко-многим).
     */
    public function texts(): HasMany
    {
        return $this->hasMany(Text::class);
    }
}