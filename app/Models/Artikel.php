<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Artikel extends Model
{
    protected $table = 'artikel';
    public $timestamps = false;

    protected $fillable = [
        'judul',
        'isi_artikel',
        'gambar',
        'tanggal',
        'id_penulis',
        'id_kategori',
        'views'
    ];

    public function penulis(): BelongsTo
    {
        return $this->belongsTo(Penulis::class, 'id_penulis', 'id');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriArtikel::class, 'id_kategori', 'id');
    }

    public function reaksis()
    {
        return $this->hasMany(Reaksi::class, 'artikel_id');
    }
}
