<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    // Nama tabel (kalau di database pakai 'peserta' bukan 'pesertas')
    protected $table = 'peserta';

    // Kolom yang boleh diisi mass-assignment
    protected $fillable = [
        'user_id',
        'id_rfid',
        'nama',
        'asal_delegasi',
        'komisi',
        'jenis_kelamin',
    ];


    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'peserta_id');
    }

    /**
     * Relasi: Peserta dimiliki oleh User tertentu
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function materi()
    {
        return $this->hasManyThrough(
            Materi::class,   // model tujuan
            Absensi::class,  // model perantara
            'peserta_id',    // foreign key di tabel absensi
            'id',            // primary key di tabel materi
            'id',            // primary key di tabel peserta
            'materi_id'      // foreign key di tabel absensi
        );
    }

    /**
     * Daftar pilihan komisi (untuk dropdown di form)
     */
    public static function getKomisiList(): array
    {
        return ['organisasi', 'program-kerja', 'rekomendasi'];
    }
}
