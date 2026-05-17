<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Materi;
use App\Models\Peserta;
use App\Models\Komisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Statistik jumlah data milik user
        $totalPeserta = Peserta::where('user_id', $userId)->count();
        $totalMateri = Materi::where('user_id', $userId)->count();
        $totalAbsensi = Absensi::where('user_id', $userId)->count();

        // Data absensi terbaru milik user
        $recentAttendance = Absensi::with(['peserta', 'materi'])
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        // Statistik komisi (masih ambil dari field peserta.komisi)
        $statsKomisi = [
            'organisasi'   => Peserta::where('user_id', $userId)->where('komisi', 'organisasi')->count(),
            'program-kerja' => Peserta::where('user_id', $userId)->where('komisi', 'program-kerja')->count(),
            'rekomendasi'  => Peserta::where('user_id', $userId)->where('komisi', 'rekomendasi')->count(),
        ];

        // Data chart kehadiran berdasarkan materi
        $attendanceByMateri = Absensi::select(
                'materis.nama as materi_nama',
                DB::raw('COUNT(absensi.id) as total_kehadiran')
            )
            ->join('materis', 'absensi.materi_id', '=', 'materis.id')
            ->where('absensi.user_id', $userId)
            ->where('absensi.status', 'hadir')
            ->groupBy('materis.nama')
            ->orderBy('materis.nama')
            ->get();

        $chartLabels = $attendanceByMateri->pluck('materi_nama');
        $chartData   = $attendanceByMateri->pluck('total_kehadiran');

        return view('dashboard', compact(
            'totalPeserta',
            'totalMateri',
            'totalAbsensi',
            'recentAttendance',
            'statsKomisi',
            'chartLabels',
            'chartData'
        ));
    }
}
