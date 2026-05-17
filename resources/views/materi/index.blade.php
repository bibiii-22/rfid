@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br py-4">
        <div class="max-w-6xl mx-auto px-4">
            <!-- Compact Header -->
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-4 mb-4">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-red-700 to-red-600 rounded-lg flex items-center justify-center">
                            <i class="ri-book-line text-xl text-white"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">Data Materi</h1>
                            <p class="text-gray-600 text-sm">Data Materi untuk sistem absensi</p>
                        </div>
                    </div>
                    <a href="{{ route('materi.create') }}"
                        class="bg-gradient-to-r from-red-700 to-red-600 hover:from-red-800 hover:to-red-700 text-white rounded-xl px-5 py-3 font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-md">
                        <i class="ri-add-line text-lg"></i>
                        <span>Tambah Data Materi</span>
                    </a>
                </div>
            </div>

            <!-- Materials Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($materis as $materi)
                    <div
                        class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 overflow-hidden hover:shadow-xl transition-all duration-300">
                        <!-- Card Header -->
                        <div
                            class="bg-gradient-to-r from-red-700 to-red-600 px-4 py-3 border-b border-gray-200/50 h-14 flex items-center">
                            <h3 class="font-bold text-white text-sm md:text-base lg:text-[1rem] break-words w-full">
                                {{ $materi->nama }}
                            </h3>

                        </div>


                        <!-- Card Body -->
                        <div class="p-4">
                            @if (!empty($materi->deskripsi))
                                <p class="text-sm text-gray-600 mb-3">{{ $materi->deskripsi }}</p>
                            @endif
                            <div class="space-y-2 text-sm text-gray-500 mb-4">
                                <div class="flex items-center">
                                    <i class="ri-stack-line w-5 h-5 mr-2 text-orange-500"></i>
                                    <span class="{{ $materi->komisis->count() >= 3 ? 'text-xs' : 'text-sm' }}">
                                        Komisi:
                                        @if ($materi->komisis->count() > 0)
                                            {{ $materi->komisis->pluck('nama')->implode(', ') }}
                                        @else
                                            <em>Tidak ada komisi</em>
                                        @endif
                                    </span>
                                </div>

                                <div class="flex items-center">
                                    <i class="ri-calendar-line w-5 h-5 mr-2 text-yellow-500"></i>
                                    <span>Dibuat: {{ $materi->created_at->format('Y-m-d H:i') }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="ri-time-line w-5 h-5 mr-2 text-yellow-500"></i>
                                    <span>Diupdate: {{ $materi->updated_at->format('Y-m-d H:i') }}</span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="grid grid-cols-2 gap-2 mt-4">
                                <a href="{{ route('materi.edit', $materi->id) }}"
                                    class="bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white rounded-lg py-2 px-3 flex items-center justify-center gap-2 transition-all duration-300 shadow-sm">
                                    <i class="ri-edit-line"></i>
                                    <span>Edit Data</span>
                                </a>

                                <form action="{{ route('materi.destroy', $materi->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin hapus?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white rounded-lg py-2 px-3 flex items-center justify-center gap-2 transition-all duration-300 shadow-sm">
                                        <i class="ri-delete-bin-line"></i>
                                        <span>Delete Data</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Empty State -->
            @if (count($materis) === 0)
                <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-8 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="ri-folder-info-line text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada data materi</h3>
                    <p class="text-gray-600 mb-4">Silakan tambahkan data materi baru</p>
                    <a href="{{ route('materi.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-700 to-red-600 text-white rounded-lg hover:from-red-800 hover:to-red-700 transition-all">
                        <i class="ri-add-line mr-2"></i> Tambah Materi
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
