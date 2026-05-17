<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Absensi;
use App\Models\Peserta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    // Menampilkan daftar materi untuk absensi
    public function index()
    {
        $materis = Materi::where('user_id', Auth::id())->latest()->paginate(10);
        return view('absensi.index', compact('materis'));
    }

    // Menyimpan absensi peserta
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_rfid' => 'required|string',
            'materi_id' => 'required|exists:materis,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        // Ambil materi beserta komisinya
        $materi = Materi::with('komisis')->where('user_id', Auth::id())->findOrFail($request->materi_id);

        // Ambil peserta berdasarkan RFID
        $peserta = Peserta::where('id_rfid', $request->id_rfid)
            ->where('user_id', Auth::id())
            ->first();

        if (!$peserta) {
            return redirect()->back()->with('error', 'Peserta tidak ditemukan dengan RFID tersebut');
        }

        // Cek apakah peserta termasuk salah satu komisi materi (pakai nama)
        $materiKomisiNames = $materi->komisis->pluck('nama')->toArray();
        if (!in_array($peserta->komisi, $materiKomisiNames)) {
            return redirect()->back()->with('error', 'Peserta tidak terdaftar untuk materi ini');
        }


        // Cek apakah peserta sudah absen
        $alreadyAbsensi = Absensi::where('peserta_id', $peserta->id)
            ->where('materi_id', $materi->id)
            ->exists();

        if ($alreadyAbsensi) {
            return redirect()->back()->with('error', 'Peserta sudah tercatat absensinya untuk materi ini');
        }

        // Simpan absensi
        Absensi::create([
            'user_id' => Auth::id(),
            'peserta_id' => $peserta->id,
            'materi_id' => $materi->id,
            'status' => 'hadir',
        ]);

        return redirect()->back()->with('success', "Absensi berhasil dicatat untuk {$peserta->nama} ({$peserta->asal_delegasi})");
    }

    // Halaman scan absensi
    public function scan(Request $request, $materiId)
    {
        $materi = Materi::with('komisis')->where('user_id', Auth::id())->findOrFail($materiId);

        $materiKomisiIds = $materi->komisis->pluck('id')->toArray();

        $pesertaQuery = Peserta::whereIn('komisi', $materiKomisiIds)
            ->where('user_id', Auth::id())
            ->with(['absensi' => function ($query) use ($materiId) {
                $query->where('materi_id', $materiId);
            }])
            ->orderBy('nama');

        // Jika ada parameter search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $pesertaQuery->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('id_rfid', 'like', "%{$search}%")
                    ->orWhere('asal_delegasi', 'like', "%{$search}%");
            });
        }

        $peserta = $pesertaQuery->get();

        return view('absensi.scan', compact('materi', 'peserta'));
    }


    // Export absensi ke PDF
    public function export($materiId)
    {
        $materi = Materi::with('komisis')->where('user_id', Auth::id())->findOrFail($materiId);

        $materiKomisiIds = $materi->komisis->pluck('id')->toArray();

        $peserta = Peserta::whereIn('komisi', $materiKomisiIds)
            ->where('user_id', Auth::id())
            ->with(['absensi' => function ($query) use ($materiId) {
                $query->where('materi_id', $materiId);
            }])
            ->orderBy('nama')
            ->get();

        $currentDateTime = Carbon::now()->translatedFormat('d F Y H:i') . ' WIB';

        $pdf = Pdf::loadView('absensi.export', compact('materi', 'peserta', 'currentDateTime'));

        return $pdf->download('absensi_' . $materi->nama . '.pdf');
    }
}
