<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Пользователи с этой ролью (связь 1-ко-многим).
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}