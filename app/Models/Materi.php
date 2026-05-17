<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;



    protected $fillable = [
        'user_id',
        'nama',
        'deskripsi',
    ];

    // Relasi ke User (si pembuat materi)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi many-to-many ke Komisi
public function komisis()
{
    return $this->belongsToMany(Komisi::class, 'komisi_materi', 'materi_id', 'komisi_id');
}



    // Relasi ke Absensi
    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }
}
