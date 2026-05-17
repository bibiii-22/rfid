<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'user_id',
        'peserta_id',
        'materi_id',
        'status',
    ];

    // Relasi ke Peserta
    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Materi
    public function materi()
    {
        return $this->belongsTo(Materi::class);
    }

    // Opsi status
    public static function statusOptions()
    {
        return [
            'hadir' => 'Hadir',
            'terlambat' => 'Terlambat',
            'tidak_hadir' => 'Tidak Hadir',
        ];
    }
}

