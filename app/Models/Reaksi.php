<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaksi extends Model
{
    use HasFactory;

    protected $fillable = ['artikel_id', 'tipe_reaksi', 'ip_address'];

    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'artikel_id');
    }
}
