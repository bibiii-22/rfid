<?php

namespace Database\Seeders;

use App\Models\Komisi;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KomisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $komisis = ['organisasi', 'program-kerja', 'rekomendasi'];

        foreach ($komisis as $nama) {
            Komisi::firstOrCreate(['nama' => $nama]);
        }
    }
}
