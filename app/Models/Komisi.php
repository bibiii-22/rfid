<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komisi extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    // Relasi many-to-many ke Materi
   public function materis()
{
    return $this->belongsToMany(Materi::class, 'komisi_materi', 'komisi_id', 'materi_id');
}

}
