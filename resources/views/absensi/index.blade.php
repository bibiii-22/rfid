@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br py-4">
        <div class="max-w-6xl mx-auto px-4">
            <!-- Compact Header -->
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-4 mb-4">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-red-700 to-red-600 rounded-lg flex items-center justify-center">
                            <i class="ri-file-list-line text-xl text-white"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">Data Materi</h1>
                            <p class="text-gray-600 text-sm">Daftar materi untuk sistem absensi</p>
                        </div>
                    </div>
                    <a href="{{ route('materi.create') }}"
                       class="bg-gradient-to-r from-red-700 to-red-600 hover:from-red-800 hover:to-red-700 text-white rounded-xl px-5 py-3 font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-md">
                        <i class="ri-add-line text-yellow-500"></i>
                        <span>Tambah Materi</span>
                    </a>
                </div>
            </div>

            <!-- Materials Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($materis as $materi)
                    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 overflow-hidden hover:shadow-xl transition-all duration-300">
                        <!-- Card Header -->
                        <div class="bg-gradient-to-r from-red-700 to-red-600 px-4 py-3 border-b border-gray-200/50">
                           <h3 class="font-bold text-white text-sm md:text-base lg:text-[1rem] break-words w-full">
        {{ $materi->nama }}
    </h3>
                        </div>

                        <!-- Card Body -->
                        <div class="p-4">
                            <!-- Daftar Komisi -->
                            <div class="mb-3 flex flex-wrap gap-2 ">
                                @foreach($materi->komisis as $komisi)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($komisi->nama === 'organisasi') bg-orange-100 text-orange-800
                                        @elseif($komisi->nama === 'program-kerja') bg-red-100 text-red-800
                                        @elseif($komisi->nama === 'rekomendasi') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst(str_replace('-', ' ', $komisi->nama)) }}
                                    </span>
                                @endforeach
                            </div>

                            <p class="text-sm text-gray-600 mb-4">{{ $materi->deskripsi }}</p>

                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <i class="ri-calendar-line w-5 h-5 mr-2 text-yellow-500"></i>
                                <span>Dibuat: {{ $materi->created_at->format('d M Y') }}</span>
                            </div>

                            <!-- Action Buttons -->
                            <div class="grid grid-cols-2 gap-2 mt-4">
                                <a href="{{ route('absensi.scan', $materi->id) }}"
                                   class="bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white rounded-lg py-2 px-3 flex items-center justify-center gap-2 transition-all duration-300 shadow-sm">
                                    <i class="ri-qr-scan-line text-yellow-500"></i>
                                    <span>Scan Absensi</span>
                                </a>

                                <a href="{{ route('absensi.export', $materi->id) }}"
                                   class="bg-gradient-to-r from-red-700 to-red-600 hover:from-red-800 hover:to-red-700 text-white rounded-lg py-2 px-3 flex items-center justify-center gap-2 transition-all duration-300 shadow-sm">
                                    <i class="ri-download-line text-yellow-500"></i>
                                    <span>Export Absensi</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Empty State -->
            @if($materis->count() === 0)
                <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-8 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="ri-folder-info-line text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada data materi</h3>
                    <p class="text-gray-600 mb-4">Silakan tambahkan data materi baru</p>
                    <a href="{{ route('materi.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-700 to-red-600 text-white rounded-lg hover:from-red-800 hover:to-red-700 transition-all">
                        <i class="ri-add-line mr-2 text-yellow-500"></i> Tambah Materi
                    </a>
                </div>
            @endif

            <!-- Pagination -->
            @if ($materis->hasPages())
                <div class="mt-6 bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-4">
                    {{ $materis->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
