<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataJadwal extends Model
{
    use HasFactory;
    public $table = 'jadwal';
    public $fillable = [
        'judul',
        'deskripsi',
        'lokasi',
        'waktu_mulai',
        'waktu_selesai',
    ];
}
