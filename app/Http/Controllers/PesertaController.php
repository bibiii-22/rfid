<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PesertaController extends Controller
{
    public function index(Request $request)
    {
        $query = Peserta::where('user_id', Auth::id());

        // Jika ada keyword pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('id_rfid', 'like', "%{$search}%")
                    ->orWhere('asal_delegasi', 'like', "%{$search}%")
                    ->orWhere('komisi', 'like', "%{$search}%");
            });
        }

        $peserta = $query->orderBy('nama')->paginate(20);

        // tetap bawa query search agar pagination tidak hilang keyword
        $peserta->appends($request->only('search'));

        return view('peserta.index', compact('peserta'));
    }

    public function create()
    {
        $komisiList = Peserta::getKomisiList();
        return view('peserta.create', compact('komisiList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_rfid' => 'required|unique:peserta,id_rfid',
            'nama' => 'required',
            'asal_delegasi' => 'required',
            'komisi' => ['required', Rule::in(Peserta::getKomisiList())],
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        Peserta::create([
            'user_id' => Auth::id(),
            'id_rfid' => $request->id_rfid,
            'nama' => $request->nama,
            'asal_delegasi' => $request->asal_delegasi,
            'komisi' => $request->komisi,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        return redirect()->route('peserta.index')->with('success', 'Peserta berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $peserta = Peserta::where('user_id', Auth::id())->findOrFail($id);
        $komisiList = Peserta::getKomisiList();
        return view('peserta.edit', compact('peserta', 'komisiList'));
    }

    public function update(Request $request, $id)
    {
        $peserta = Peserta::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'id_rfid' => [
                'required',
                Rule::unique('peserta', 'id_rfid')->ignore($peserta->id),
            ],
            'nama' => 'required',
            'asal_delegasi' => 'required',
            'komisi' => ['required', Rule::in(Peserta::getKomisiList())],
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        $peserta->update([
            'id_rfid' => $request->id_rfid,
            'nama' => $request->nama,
            'asal_delegasi' => $request->asal_delegasi,
            'komisi' => $request->komisi,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        return redirect()->route('peserta.index')->with('success', 'Peserta berhasil diupdate.');
    }

    public function destroy($id)
    {
        $peserta = Peserta::where('user_id', Auth::id())->findOrFail($id);
        $peserta->delete();

        return redirect()->route('peserta.index')->with('success', 'Peserta berhasil dihapus.');
    }

    public function export()
    {
        $peserta = Peserta::where('user_id', Auth::id())->orderBy('nama')->get();
        $currentDateTime = Carbon::now()->translatedFormat('d F Y H:i') . ' WIB';

        $pdf = Pdf::loadView('peserta.export', compact('peserta', 'currentDateTime'));
        return $pdf->download('daftar_peserta.pdf');
    }
}
