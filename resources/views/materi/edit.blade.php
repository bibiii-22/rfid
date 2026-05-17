@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br py-4">
        <div class="max-w-6xl mx-auto px-4">
            <!-- Header -->
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-4 mb-4">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-red-700 to-red-600 rounded-lg flex items-center justify-center">
                        <i class="ri-edit-box-line text-xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Edit Materi</h1>
                        <p class="text-gray-600 text-sm">Perbarui informasi materi untuk sistem absensi</p>
                    </div>
                </div>
            </div>

            <!-- Form Edit Materi -->
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-6 mb-8">
                <form action="{{ route('materi.update', $materi->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Materi -->
                        <div class="md:col-span-2">
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Materi
                            </label>
                            <input type="text" name="nama" id="nama" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent"
                                placeholder="Masukkan nama materi" value="{{ old('nama', $materi->nama) }}">
                            @error('nama')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="md:col-span-2">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi
                            </label>
                            <textarea name="deskripsi" id="deskripsi" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent"
                                placeholder="Masukkan deskripsi materi (opsional)">{{ old('deskripsi', $materi->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Komisi -->
                        <div class="md:col-span-2">
                            <label class="block font-medium">Komisi yang boleh ikut absen</label>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach ($komisiList as $komisi)
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="komisi_ids[]" value="{{ $komisi->id }}"
                                            {{ in_array($komisi->id, old('komisi_ids', $materi->komisis->pluck('id')->toArray())) ? 'checked' : '' }}
                                            class="w-4 h-4 rounded border-gray-300 text-red-500 focus:ring-red-500 accent-red-500">

                                        <span>{{ $komisi->nama }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('komisi_ids')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Tombol Action -->
                    <div class="flex justify-end space-x-3 pt-4">
                        <a href="{{ route('materi.index') }}"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-600 shadow-sm transition-colors">
                            <i class="ri-close-line w-4 h-4 inline mr-1 text-yellow-500"></i>
                            Batal
                        </a>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-red-700 to-red-600 hover:from-red-800 hover:to-red-700 border border-transparent rounded-md focus:outline-none focus:ring-2 focus:ring-red-600 cursor-pointer shadow-sm transition-all">
                            <i class="ri-save-line w-4 h-4 inline mr-1 text-yellow-500"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
