@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br py-4">
        <div class="max-w-6xl mx-auto px-4">
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-4 mb-4">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-red-700 to-red-600 rounded-lg flex items-center justify-center">
                            <i class="ri-rfid-line text-xl text-white"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">Scan Absensi RFID</h1>
                            <p class="text-gray-600 text-sm">Tempelkan kartu RFID</p>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-orange-600 to-orange-500 rounded-xl p-4 text-white min-w-[250px]">
                        <div class="text-sm font-bold opacity-90 text-center">{{ $materi->nama }}</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="lg:col-span-1">
                    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 p-4">
                        <h2 class="text-lg font-bold text-gray-900 mb-3 text-center">Area Pemindaian</h2>

                        <div
                            class="relative bg-gradient-to-br from-gray-50 to-gray-100/50 rounded-2xl p-6 border-2 border-dashed border-gray-300 hover:border-orange-400 transition-all duration-300">
                            <div class="flex flex-col items-center space-y-3">
                                <div class="relative">
                                    <div class="absolute inset-0 w-16 h-16 bg-red-400/20 rounded-full animate-ping"></div>
                                    <div
                                        class="relative w-16 h-16 bg-gradient-to-r from-red-700 to-red-600 rounded-full flex items-center justify-center shadow-lg">
                                        <i class="ri-rfid-line text-2xl text-white"></i>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h3 class="text-lg font-bold text-gray-900">Siap Memindai</h3>
                                    <p class="text-gray-600 text-sm">Tempelkan kartu RFID</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                    <span class="text-xs text-gray-600">Aktif</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-2">
                            @php
                                $total = count($peserta);
                                $hadir = collect($peserta)
                                    ->filter(function ($p) use ($materi) {
                                        $attendance = $p->absensi->where('materi_id', $materi->id)->first();
                                        return $attendance && $attendance->status === 'hadir';
                                    })
                                    ->count();
                                $terlambat = collect($peserta)
                                    ->filter(function ($p) use ($materi) {
                                        $attendance = $p->absensi->where('materi_id', $materi->id)->first();
                                        return $attendance && $attendance->status === 'terlambat';
                                    })
                                    ->count();
                                $belum_absen = collect($peserta)
                                    ->filter(function ($p) use ($materi) {
                                        $attendance = $p->absensi->where('materi_id', $materi->id)->first();
                                        return !$attendance || $attendance->status === 'belum_absen';
                                    })
                                    ->count();
                            @endphp

                            <div class="bg-gray-50 rounded-lg p-2 text-center">
                                <div class="text-lg font-bold text-gray-900">{{ $total }}</div>
                                <div class="text-xs text-gray-600">Total</div>
                            </div>
                            <div class="bg-green-50 rounded-lg p-2 text-center">
                                <div class="text-lg font-bold text-green-600">{{ $hadir }}</div>
                                <div class="text-xs text-gray-600">Hadir</div>
                            </div>
                            <div class="bg-yellow-50 rounded-lg p-2 text-center">
                                <div class="text-lg font-bold text-yellow-600">{{ $terlambat }}</div>
                                <div class="text-xs text-gray-600">Terlambat</div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-2 text-center">
                                <div class="text-lg font-bold text-gray-500">{{ $belum_absen }}</div>
                                <div class="text-xs text-gray-600">Belum</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/50 overflow-hidden">
                        <div
                            class="px-4 py-3 border-b border-gray-200/50 bg-gradient-to-r from-gray-50 to-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                            <h3 class="text-lg font-bold text-gray-900">Daftar Kehadiran</h3>
                            <!-- Search Input -->
                            <form action="{{ route('absensi.scan', $materi->id) }}" method="GET"
                                class="flex items-center mb-4">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari nama, RFID, delegasi..."
                                    class="px-3 py-1.5 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-orange-500 focus:outline-none">
                                <button type="submit"
                                    class="ml-2 px-3 py-1.5 text-sm bg-orange-100 text-orange-700 rounded-md hover:bg-orange-200 transition-colors cursor-pointer">
                                    <i class="ri-search-line"></i>
                                </button>
                                <a href="{{ route('absensi.scan', $materi->id) }}"
                                    class="ml-2 px-3 py-1.5 text-sm bg-gray-200 text-gray-900 rounded-md hover:bg-gray-300 transition-colors cursor-pointer flex items-center">
                                    <i class="ri-refresh-line mr-1"></i> Clear
                                </a>

                            </form>
                        </div>


                        <div class="overflow-x-auto max-h-96 overflow-y-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm" id="attendanceTable">
                                <thead class="bg-gray-50 sticky top-0">
                                    <tr>
                                        <th class="py-2 px-3 text-left text-xs font-semibold text-gray-900 uppercase">No
                                        </th>
                                        <th class="py-2 px-3 text-left text-xs font-semibold text-gray-900 uppercase">RFID
                                        </th>
                                        <th class="py-2 px-3 text-left text-xs font-semibold text-gray-900 uppercase">Nama
                                        </th>
                                        <th class="py-2 px-3 text-left text-xs font-semibold text-gray-900 uppercase">
                                            Delegasi</th>
                                        <th class="py-2 px-3 text-left text-xs font-semibold text-gray-900 uppercase">Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($peserta as $index => $p)
                                        @php
                                            $attendance = $p->absensi->where('materi_id', $materi->id)->first();
                                            $status = $attendance ? $attendance->status : 'belum_absen';
                                        @endphp
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="py-2 px-3 text-xs text-gray-900">{{ $index + 1 }}</td>
                                            <td class="py-2 px-3 text-xs font-mono text-gray-900 bg-gray-50/30 rounded">
                                                {{ $p->id_rfid }}</td>
                                            <td class="py-2 px-3 text-xs font-medium text-gray-900">{{ $p->nama }}
                                            </td>
                                            <td class="py-2 px-3 text-xs text-gray-500">{{ $p->asal_delegasi }}</td>
                                            <td class="py-2 px-3 text-xs">
                                                <span
                                                    class="px-2 py-1 inline-flex items-center text-xs leading-4 font-semibold rounded-full
                                    @if ($status === 'hadir') bg-green-100 text-green-800
                                    @elseif($status === 'terlambat') bg-yellow-100 text-yellow-800
                                    @elseif($status === 'tidak_hadir') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                                    @if ($status === 'hadir')
                                                        Hadir
                                                    @elseif($status === 'terlambat')
                                                        Terlambat
                                                    @elseif($status === 'tidak_hadir')
                                                        Tidak Hadir
                                                    @else
                                                        Belum
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success') || session('error'))
                <div id="statusModal"
                    class="fixed inset-0 flex items-center justify-center z-50 bg-black/50 backdrop-blur-sm">
                    <div class="bg-white rounded-2xl p-6 max-w-sm w-full mx-4 shadow-2xl transform animate-bounce">
                        <div class="text-center">
                            @if (session('success'))
                                <div
                                    class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-r from-green-400 to-emerald-500 mb-4">
                                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-3">Absensi Berhasil!</h3>
                                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-4">
                                    {{ session('success') }}
                                </div>
                            @elseif(session('error'))
                                <div
                                    class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-r from-red-400 to-rose-500 mb-4">
                                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-3">Absensi Gagal!</h3>
                                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-4">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <button type="button" onclick="closeModal()"
                                class="w-full bg-gradient-to-r from-red-700 to-red-600 hover:from-red-800 hover:to-red-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>

                <script>
                    // Auto close modal setelah 2 detik
                    setTimeout(() => {
                        if (document.getElementById('statusModal')) {
                            closeModal();
                        }
                    }, 2000);
                </script>
            @endif


            <form method="POST" action="{{ route('absensi.store') }}" id="rfid_form"
                style="opacity: 0; position: absolute; left: -9999px;">
                @csrf
                <input type="hidden" name="materi_id" value="{{ $materi->id }}">
                <input type="text" id="rfid_input" name="id_rfid" required autocomplete="off">
                <button type="submit" id="hidden_submit"></button>
            </form>

            <div id="scan_feedback"
                class="fixed inset-0 flex items-center justify-center z-40 bg-black/50 backdrop-blur-sm hidden">
                <div class="bg-white rounded-2xl p-6 max-w-xs w-full mx-4 shadow-2xl">
                    <div class="text-center">
                        <div class="relative w-16 h-16 mx-auto mb-4">
                            <div class="absolute inset-0 bg-red-400/20 rounded-full animate-ping"></div>
                            <div
                                class="relative w-16 h-16 bg-gradient-to-r from-red-700 to-red-600 rounded-full flex items-center justify-center">
                                <i class="ri-loader-4-line text-2xl text-white animate-spin"></i>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Memproses...</h3>
                        <p class="text-gray-600 text-sm">Sedang memproses kartu RFID</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes bounce {

            0%,
            20%,
            53%,
            80%,
            100% {
                transform: translate3d(0, 0, 0);
            }

            40%,
            43% {
                transform: translate3d(0, -15px, 0);
            }

            70% {
                transform: translate3d(0, -7px, 0);
            }

            90% {
                transform: translate3d(0, -2px, 0);
            }
        }

        .animate-bounce {
            animation: bounce 0.6s ease-in-out;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rfidInput = document.getElementById('rfid_input');
            const scanFeedback = document.getElementById('scan_feedback');
            const rfidForm = document.getElementById('rfid_form');
            let pendingValue = null; // simpan RFID sementara

            rfidInput.focus();

            function handleRfidScan(value) {
                if (value.length >= 8) {
                    console.log('RFID Terbaca:', value);
                    scanFeedback.classList.remove('hidden');
                    pendingValue = value; // simpan sementara, jangan submit dulu
                }
            }

            rfidInput.addEventListener('input', function(e) {
                handleRfidScan(e.target.value);
            });

            let lastValue = '';
            setInterval(() => {
                if (rfidInput.value && rfidInput.value !== lastValue) {
                    lastValue = rfidInput.value;
                    handleRfidScan(lastValue);
                }
            }, 200);

            window.addEventListener('beforeunload', function() {
                rfidInput.value = '';
            });

            // fungsi close modal
            window.closeModal = function() {
                document.getElementById('statusModal').classList.add('hidden');
                if (pendingValue) {
                    // isi form lalu submit
                    rfidInput.value = pendingValue;
                    scanFeedback.classList.remove('hidden');
                    setTimeout(() => {
                        rfidForm.submit();
                    }, 200);
                }
            }
        });
    </script>

@endsection
