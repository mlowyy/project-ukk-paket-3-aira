<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Pengaduan Sarana Sekolah</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background: #fff;
            font-size: 12pt;
        }
        .kop-surat {
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .table-print {
            width: 100%;
            border-collapse: collapse;
        }
        .table-print th, .table-print td {
            border: 1px solid #000;
            padding: 6px 8px;
            font-size: 10pt;
        }
        .table-print th {
            background-color: #f2f2f2;
            text-align: center;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body class="p-4">
    <!-- Tombol Cetak / Aksi -->
    <div class="no-print mb-4 d-flex gap-2">
        <button onclick="window.print()" class="btn btn-primary btn-sm">
            Cetak Dokumen (Print)
        </button>
        <button onclick="window.close()" class="btn btn-secondary btn-sm">
            Tutup
        </button>
    </div>

    <!-- Kop Surat Sekolah -->
    <div class="kop-surat text-center">
        <h4 class="fw-bold mb-0 text-uppercase">PEMERINTAH DAERAH PROVINSI</h4>
        <h4 class="fw-bold mb-0 text-uppercase">DINAS PENDIDIKAN</h4>
        <h3 class="fw-bold mb-1 text-uppercase">SMK NEGERI CONTOH KEJURUAN</h3>
        <p class="mb-0 small">Jl. Pendidikan No. 123, Telepon: (021) 1234567, Website: www.smkcontoh.sch.id</p>
    </div>

    <!-- Judul Dokumen -->
    <div class="text-center my-3">
        <h5 class="fw-bold text-uppercase mb-1" style="text-decoration: underline;">REKAPITULASI PENGADUAN SARANA DAN PRASARANA SEKOLAH</h5>
        <p class="small text-muted mb-0">Dokumen Uji Kompetensi Keahlian (UKK) Rekayasa Perangkat Lunak 2025/2026</p>
        <p class="small text-muted">Dicetak pada: {{ date('d F Y, H:i') }} WIB</p>
    </div>

    <!-- Tabel Rekapitulasi -->
    <table class="table-print my-3">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 80px;">Tanggal</th>
                <th style="width: 100px;">NIS / Kelas</th>
                <th style="width: 130px;">Kategori</th>
                <th style="width: 130px;">Lokasi</th>
                <th>Keterangan Kerusakan</th>
                <th style="width: 90px;">Status</th>
                <th style="width: 180px;">Umpan Balik (Feedback)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($aspirasis as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $item->created_at->format('d/m/Y') }}</td>
                <td>{{ $item->inputAspirasi->nis ?? '-' }} ({{ $item->inputAspirasi->siswa->kelas ?? '-' }})</td>
                <td>{{ $item->kategori->ket_kategori ?? '-' }}</td>
                <td>{{ $item->inputAspirasi->lokasi ?? '-' }}</td>
                <td>{{ $item->inputAspirasi->ket ?? '-' }}</td>
                <td class="text-center fw-bold">{{ $item->status }}</td>
                <td>{{ $item->feedback ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center py-3">Tidak ada data pengaduan yang tercatat.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda Tangan -->
    <div class="row mt-5 pt-3">
        <div class="col-6 text-center">
            <p class="mb-5">Mengetahui,<br>Kepala Sekolah,</p>
            <p class="fw-bold mb-0" style="text-decoration: underline;">Drs. H. PENGUJI UKK, M.Pd.</p>
            <p class="small">NIP. 19750101 200003 1 001</p>
        </div>
        <div class="col-6 text-center">
            <p class="mb-5">{{ date('d F Y') }}<br>Petugas Sarana Prasarana,</p>
            <p class="fw-bold mb-0" style="text-decoration: underline;">ADMINISTRATOR SARPRAS</p>
            <p class="small">NIP. 19850505 201001 1 002</p>
        </div>
    </div>
</body>
</html>
