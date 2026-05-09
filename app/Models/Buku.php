<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Buku extends Model
{
    use HasFactory;

    protected $table='bukus';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'judul',
        'penulis',
        'penerbit',
        'tahun',
        'isbn',
        'jumlah',
        'Kategori_id',
    ];

    public function kategori():BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }
}
