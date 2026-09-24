@extends('layouts.app')

@section('title', 'Halaman Umpan Balik Aspirasi & Kelola Pengaduan')

@section('content')
<!-- Header & Judul Halaman -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h3 class="fw-bold text-dark mb-1">
            <i class="bi bi-chat-left-dots text-primary me-2"></i>Halaman Umpan Balik Aspirasi
        </h3>
        <p class="text-muted small mb-0">Kelola daftar seluruh aspirasi sarana, berikan umpan balik (feedback), dan perbarui status penyelesaian.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.cetak', request()->query()) }}" target="_blank" class="btn btn-outline-secondary fw-semibold">
            <i class="bi bi-printer me-1"></i> Cetak Rekapitulasi
        </a>
        <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-primary fw-semibold">
            <i class="bi bi-tags me-1"></i> Kelola Kategori
        </a>
    </div>
</div>

<!-- 4 Kotak Ringkasan Statistik -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card card-custom bg-white p-3 border-start border-primary border-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold">Total Aspirasi</div>
                    <div class="fs-3 fw-bold text-dark">{{ $stats['total'] }}</div>
                </div>
                <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-3">
                    <i class="bi bi-collection-fill fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card card-custom bg-white p-3 border-start border-warning border-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold">Menunggu</div>
                    <div class="fs-3 fw-bold text-warning">{{ $stats['menunggu'] }}</div>
                </div>
                <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-3">
                    <i class="bi bi-hourglass-split fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card card-custom bg-white p-3 border-start border-info border-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold">Dalam Proses</div>
                    <div class="fs-3 fw-bold text-info">{{ $stats['proses'] }}</div>
                </div>
                <div class="rounded-circle bg-info bg-opacity-10 text-info p-3">
                    <i class="bi bi-gear-wide-connected fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card card-custom bg-white p-3 border-start border-success border-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold">Selesai</div>
                    <div class="fs-3 fw-bold text-success">{{ $stats['selesai'] }}</div>
                </div>
                <div class="rounded-circle bg-success bg-opacity-10 text-success p-3">
                    <i class="bi bi-check-circle-fill fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Panel Filter Aspirasi (Per Tanggal, Per Bulan, Per Siswa, Per Kategori) Sesuai Soal UKK -->
<div class="card card-custom bg-white p-4 mb-4">
    <div class="d-flex align-items-center gap-2 mb-3">
        <i class="bi bi-funnel-fill text-primary"></i>
        <h6 class="fw-bold text-dark mb-0">Filter Aspirasi Keseluruhan (Tanggal, Bulan, Siswa, Kategori)</h6>
    </div>
    <form action="{{ route('admin.dashboard') }}" method="GET">
        <div class="row g-3">
            <!-- Filter Per Tanggal -->
            <div class="col-md-3 col-sm-6">
                <label class="form-label small fw-semibold text-muted">Per Tanggal</label>
                <input type="date" name="tanggal" class="form-control form-control-sm" value="{{ request('tanggal') }}">
            </div>

            <!-- Filter Per Bulan -->
            <div class="col-md-3 col-sm-6">
                <label class="form-label small fw-semibold text-muted">Per Bulan</label>
                <select name="bulan" class="form-select form-select-sm">
                    <option value="">Semua Bulan</option>
                    @php
                        $bulanIndo = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                    @endphp
                    @foreach($bulanIndo as $num => $namaBulan)
                        <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>{{ $namaBulan }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Per Siswa (NIS) -->
            <div class="col-md-3 col-sm-6">
                <label class="form-label small fw-semibold text-muted">Per Siswa (NIS)</label>
                <select name="nis" class="form-select form-select-sm">
                    <option value="">Semua Siswa</option>
                    @foreach($siswas as $s)
                        <option value="{{ $s->nis }}" {{ request('nis') == $s->nis ? 'selected' : '' }}>
                            NIS: {{ $s->nis }} ({{ $s->kelas }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Per Kategori -->
            <div class="col-md-3 col-sm-6">
                <label class="form-label small fw-semibold text-muted">Per Kategori</label>
                <select name="id_kategori" class="form-select form-select-sm">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id_kategori }}" {{ request('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
                            {{ $k->ket_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Status -->
            <div class="col-md-3 col-sm-6">
                <label class="form-label small fw-semibold text-muted">Status Penyelesaian</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Proses" {{ request('status') == 'Proses' ? 'selected' : '' }}>Proses</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <!-- Kata Kunci / Lokasi / Keterangan -->
            <div class="col-md-6 col-sm-12">
                <label class="form-label small fw-semibold text-muted">Cari Kata Kunci (Lokasi/Keterangan)</label>
                <input type="text" name="q" class="form-control form-control-sm" placeholder="Ketik lokasi atau kata kunci kerusakan..." value="{{ request('q') }}">
            </div>

            <!-- Tombol Filter -->
            <div class="col-md-3 col-sm-12 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary btn-sm w-100 fw-semibold">
                    <i class="bi bi-search me-1"></i> Terapkan
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm text-secondary border w-50">
                    Reset
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Tabel Daftar Aspirasi & Umpan Balik -->
<div class="card card-custom bg-white overflow-hidden">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold text-dark mb-0">Daftar Pengaduan Aspirasi Sarana</h6>
        <span class="badge bg-light text-secondary border">Total Data: {{ $aspirasis->total() }}</span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-secondary small text-uppercase">
                <tr>
                    <th class="ps-3" style="width: 50px;">No</th>
                    <th>Tanggal</th>
                    <th>Siswa</th>
                    <th>Kategori & Lokasi</th>
                    <th style="min-width: 220px;">Keterangan Sarana</th>
                    <th>Status</th>
                    <th style="min-width: 200px;">Umpan Balik (Feedback)</th>
                    <th class="text-center pe-3" style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aspirasis as $index => $item)
                <tr>
                    <td class="ps-3 fw-semibold text-muted">{{ $aspirasis->firstItem() + $index }}</td>
                    <td>
                        <div class="fw-semibold text-dark small">{{ $item->created_at->format('d/m/Y') }}</div>
                        <div class="text-muted" style="font-size: 0.75rem;">{{ $item->created_at->format('H:i') }} WIB</div>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark small">NIS: {{ $item->inputAspirasi->nis ?? '-' }}</div>
                        <span class="badge bg-light text-primary border small" style="font-size: 0.7rem;">
                            {{ $item->inputAspirasi->siswa->kelas ?? '-' }}
                        </span>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark small">{{ $item->kategori->ket_kategori ?? '-' }}</div>
                        <div class="text-muted small"><i class="bi bi-geo-alt text-danger me-1"></i>{{ $item->inputAspirasi->lokasi ?? '-' }}</div>
                    </td>
                    <td>
                        <p class="mb-0 text-dark small text-truncate" style="max-width: 260px;" title="{{ $item->inputAspirasi->ket }}">
                            {{ $item->inputAspirasi->ket ?? '-' }}
                        </p>
                        @if(optional($item->inputAspirasi)->foto)
                            <a href="{{ asset('storage/' . $item->inputAspirasi->foto) }}" target="_blank" class="badge bg-light text-info border text-decoration-none mt-1">
                                <i class="bi bi-image me-1"></i> Lihat Foto
                            </a>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-status 
                            @if($item->status == 'Menunggu') badge-menunggu 
                            @elseif($item->status == 'Proses') badge-proses 
                            @else badge-selesai @endif">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td>
                        @if($item->feedback)
                            <div class="small text-dark p-2 bg-light rounded text-truncate" style="max-width: 220px;" title="{{ $item->feedback }}">
                                <i class="bi bi-chat-quote me-1 text-primary"></i> {{ $item->feedback }}
                            </div>
                        @else
                            <span class="text-muted small fst-italic">Belum ada umpan balik</span>
                        @endif
                    </td>
                    <td class="text-center pe-3">
                        <div class="btn-group btn-group-sm">
                            <!-- Tombol Modal Umpan Balik & Status -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFeedback{{ $item->id_aspirasi }}" title="Beri Umpan Balik / Ubah Status">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <!-- Tombol Detail -->
                            <a href="{{ route('admin.aspirasi.show', $item->id_aspirasi) }}" class="btn btn-outline-secondary" title="Lihat Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <!-- Tombol Hapus -->
                            <form action="{{ route('admin.aspirasi.destroy', $item->id_aspirasi) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data aspirasi ini?');" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Modal Berikan Umpan Balik & Ubah Status -->
                        <div class="modal fade text-start" id="modalFeedback{{ $item->id_aspirasi }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.aspirasi.update', $item->id_aspirasi) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Umpan Balik & Status Aspirasi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3 p-3 bg-light rounded small">
                                                <div><strong>Pelapor:</strong> NIS {{ $item->inputAspirasi->nis }} ({{ $item->inputAspirasi->siswa->kelas ?? '' }})</div>
                                                <div><strong>Lokasi:</strong> {{ $item->inputAspirasi->lokasi }}</div>
                                                <div><strong>Kerusakan:</strong> {{ $item->inputAspirasi->ket }}</div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Status Penyelesaian <span class="text-danger">*</span></label>
                                                <select name="status" class="form-select" required>
                                                    <option value="Menunggu" {{ $item->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                                    <option value="Proses" {{ $item->status == 'Proses' ? 'selected' : '' }}>Proses (Dalam Perbaikan)</option>
                                                    <option value="Selesai" {{ $item->status == 'Selesai' ? 'selected' : '' }}>Selesai (Tuntas)</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Umpan Balik (Feedback) untuk Siswa</label>
                                                <textarea name="feedback" rows="4" class="form-control" placeholder="Tuliskan keterangan tindakan, perbaikan yang telah dilakukan, atau tindak lanjut tim teknisi...">{{ old('feedback', $item->feedback) }}</textarea>
                                                <div class="form-text small">Umpan balik ini akan langsung dapat dibaca oleh siswa pada halaman histori pengaduan.</div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary fw-semibold">
                                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                        Tidak ada data aspirasi yang sesuai dengan filter.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="card-footer bg-white py-3 d-flex justify-content-between align-items-center">
        <span class="small text-muted">Menampilkan data {{ $aspirasis->firstItem() ?? 0 }} sampai {{ $aspirasis->lastItem() ?? 0 }} dari {{ $aspirasis->total() }}</span>
        <div>{{ $aspirasis->links('pagination::bootstrap-5') }}</div>
    </div>
</div>
@endsection
