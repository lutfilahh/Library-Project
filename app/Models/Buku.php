<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table='bukus';
    protected $primaryKey = 'id';
    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'tahun',
        'isbn',
        'kategori',
        'status',
    ];

    public function pinjam()
    {
        return $this->hasMany(Pinjam::class, 'buku_id', 'id');
    }
}
