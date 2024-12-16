<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gedung extends Model
{
    use HasFactory;
    protected $fillable = [
        'kategori_berita_id',
        'judul',
        'deskripsi',
        'image'
    ];
}
