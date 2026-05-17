<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Absensi {{ $materi->judul }}</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 8px; text-align: left; }
         .footer {
            text-align: right;
            font-size: 12px;
            margin-top: 30px;
        }

    </style>
</head>
<body>
    <h2>Daftar Absensi</h2>
    <p><strong>Materi:</strong> {{ $materi->nama }}</p>
    <p><strong>Komisi:</strong> {{ $materi->komisi }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peserta</th>
                <th>Asal Delegasi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peserta as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->nama }}</td>
                    <td>{{ $p->asal_delegasi }}</td>
                    <td>
                        {{ $p->absensi->first() ? ucfirst($p->absensi->first()->status) : 'Tidak Hadir' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        Dicetak pada: {{ $currentDateTime }}
    </div>
</body>
</html>
