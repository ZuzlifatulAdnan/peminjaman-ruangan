<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'ruangan_id',
        'ukm_id',
        'tanggal_pesan',
        'waktu_mulai',
        'waktu_selesai',
        'tujuan',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }
    public function ukm()
    {
        return $this->belongsTo(Ukm::class);
    }
}
