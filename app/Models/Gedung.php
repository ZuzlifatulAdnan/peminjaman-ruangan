<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gedung extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
    ];
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }
}
