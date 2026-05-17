<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Komisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{
    public function index()
    {
        $materis = Materi::with('komisis')
            ->where('user_id', Auth::id())
            ->orderBy('nama')
            ->get();

        return view('materi.index', compact('materis'));
    }

    public function create()
    {
        $komisiList = Komisi::all();
        return view('materi.create', compact('komisiList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'komisi_ids' => 'required|array',
            'komisi_ids.*' => 'exists:komisis,id',
        ]);

        $materi = Materi::create([
            'user_id' => Auth::id(),
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        $materi->komisis()->sync($request->komisi_ids);

        return redirect()->route('materi.index')->with('success', 'Materi berhasil ditambahkan.');
    }

    public function show($id)
    {
        $materi = Materi::with('komisis')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('materi.show', compact('materi'));
    }

    public function edit($id)
    {
        $materi = Materi::with('komisis')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $komisiList = Komisi::all();

        return view('materi.edit', compact('materi', 'komisiList'));
    }

    public function update(Request $request, $id)
    {
        $materi = Materi::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'komisi_ids' => 'required|array',
            'komisi_ids.*' => 'exists:komisis,id',
        ]);

        $materi->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        $materi->komisis()->sync($request->komisi_ids);

        return redirect()->route('materi.index')->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $materi = Materi::where('user_id', Auth::id())->findOrFail($id);

        $materi->komisis()->detach();
        $materi->delete();

        return redirect()->route('materi.index')->with('success', 'Materi berhasil dihapus.');
    }
}
