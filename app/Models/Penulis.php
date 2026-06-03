<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penulis extends Authenticatable
{
    protected $table = 'penulis';
    public $timestamps = false;

    protected $fillable = [
        'nama_lengkap',
        'user_name',
        'password',
        'foto',
    ];

    protected $hidden = ['password'];

    public function getAuthIdentifierName(): string
    {
        return 'user_name';
    }

    public function artikel(): HasMany
    {
        return $this->hasMany(Artikel::class, 'id_penulis', 'id');
    }
}
