@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br py-4">
    <div class="max-w-6xl mx-auto px-4">

        <!-- Compact Header -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-4 mb-4 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-r from-red-600 to-orange-500 rounded-lg flex items-center justify-center">
                    <i class="ri-user-line text-xl text-white"></i>
                </div>
                <div class="truncate">
                    <h1 class="text-xl font-bold text-gray-900 truncate">Data Peserta</h1>
                    <p class="text-gray-600 text-sm truncate">Data peserta untuk sistem absensi</p>
                </div>
            </div>
            <a href="{{ route('peserta.create') }}"
               class="bg-gradient-to-r from-red-600 to-orange-500 hover:from-red-700 hover:to-orange-600 text-white rounded-xl px-5 py-3 font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-md w-full lg:w-auto text-center">
                <i class="ri-add-line text-lg"></i>
                <span>Tambah Data Peserta</span>
            </a>
        </div>

        <!-- Participant Data -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200/50 bg-gradient-to-r from-gray-50 to-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                <h3 class="text-lg font-medium text-gray-900 truncate">Daftar Peserta Terdaftar</h3>
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 flex-wrap">

                    <!-- Form Search -->
                    <form method="GET" action="{{ route('peserta.index') }}" class="flex items-center flex-1 sm:flex-auto">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari peserta..."
                               class="w-full sm:w-auto px-3 py-1.5 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-orange-500 focus:outline-none">
                        <button type="submit" class="ml-2 px-3 py-1.5 text-sm bg-orange-100 text-orange-700 rounded-md hover:bg-orange-200 transition-colors cursor-pointer flex items-center justify-center">
                            <i class="ri-search-line"></i>
                        </button>
                    </form>

                    <!-- Tombol Export -->
                    <a href="{{ route('peserta.export') }}"
                       class="flex items-center px-3 py-1.5 text-sm bg-orange-100 text-orange-700 rounded-md hover:bg-orange-200 transition-colors whitespace-nowrap">
                        <i class="ri-download-line w-4 h-4 mr-1"></i>
                        Export
                    </a>

                    <!-- Tombol Clear -->
                    <a href="{{ route('peserta.index') }}"
                       class="flex items-center px-3 py-1.5 text-sm bg-gray-200 text-gray-900 rounded-md hover:bg-gray-300 transition-colors cursor-pointer whitespace-nowrap">
                        <i class="ri-refresh-line mr-1"></i> Clear
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200/50 text-sm">
                    <thead class="bg-gray-50/80">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">ID Kartu</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Asal Delegasi</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Komisi</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white/60 divide-y divide-gray-200/50">
                        @foreach ($peserta as $index => $p)
                            <tr class="hover:bg-gray-50/80 transition-colors duration-150">
                                <td class="px-4 py-2 whitespace-nowrap text-sm font-mono text-gray-900">
                                    {{ ($peserta->currentPage() - 1) * $peserta->perPage() + $index + 1 }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm font-mono text-gray-900">{{ $p->id_rfid }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900 truncate max-w-[120px]">{{ $p->nama }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 truncate max-w-[120px]">{{ $p->asal_delegasi }}</td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    @php
                                        $badgeColor = [
                                            'organisasi' => 'bg-red-100 text-red-800',
                                            'program-kerja' => 'bg-orange-100 text-orange-800',
                                            'rekomendasi' => 'bg-yellow-100 text-yellow-800',
                                        ][$p->komisi] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeColor }}">
                                        {{ ucfirst(str_replace('-', ' ', $p->komisi)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">{{ $p->jenis_kelamin }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">{{ $p->created_at->format('d-m-Y') }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm font-medium flex gap-2">
                                    <a href="{{ route('peserta.edit', $p->id) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="ri-edit-line w-4 h-4 inline"></i>
                                    </a>
                                    <form action="{{ route('peserta.destroy', $p->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 cursor-pointer"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus peserta ini?')">
                                            <i class="ri-delete-bin-line w-4 h-4 inline"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Custom Pagination --}}
            @if ($peserta->hasPages())
                <div class="px-4 py-3 border-t border-gray-200/50 bg-gray-50/80 flex flex-wrap justify-end gap-1">
                    @if ($peserta->onFirstPage())
                        <span class="px-3 py-1.5 bg-gray-200 text-gray-500 rounded-md cursor-not-allowed">Prev</span>
                    @else
                        <a href="{{ $peserta->previousPageUrl() }}" class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors">Prev</a>
                    @endif

                    @php
                        $start = max(1, $peserta->currentPage() - 2);
                        $end = min($peserta->lastPage(), $peserta->currentPage() + 2);
                    @endphp

                    @if ($start > 1)
                        <a href="{{ $peserta->url(1) }}" class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors">1</a>
                        @if ($start > 2)
                            <span class="px-3 py-1.5 text-gray-500">...</span>
                        @endif
                    @endif

                    @for ($i = $start; $i <= $end; $i++)
                        @if ($i == $peserta->currentPage())
                            <span class="px-3 py-1.5 bg-orange-600 text-white rounded-md">{{ $i }}</span>
                        @else
                            <a href="{{ $peserta->url($i) }}" class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors">{{ $i }}</a>
                        @endif
                    @endfor

                    @if ($end < $peserta->lastPage())
                        @if ($end < $peserta->lastPage() - 1)
                            <span class="px-3 py-1.5 text-gray-500">...</span>
                        @endif
                        <a href="{{ $peserta->url($peserta->lastPage()) }}" class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors">{{ $peserta->lastPage() }}</a>
                    @endif

                    @if ($peserta->hasMorePages())
                        <a href="{{ $peserta->nextPageUrl() }}" class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors">Next</a>
                    @else
                        <span class="px-3 py-1.5 bg-gray-200 text-gray-500 rounded-md cursor-not-allowed">Next</span>
                    @endif
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
