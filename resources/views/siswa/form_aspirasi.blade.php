@extends('layouts.app')

@section('title', 'Form Pengaduan Aspirasi Sarana Sekolah')

@section('content')
<div class="row g-4">
    <!-- Kolom Kiri: Form Input Aspirasi -->
    <div class="col-lg-7">
        <div class="card card-custom shadow-sm bg-white p-4">
            <div class="d-flex align-items-center gap-3 mb-3 border-bottom pb-3">
                <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
                    <i class="bi bi-megaphone fs-3"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-0 text-dark">Form Aspirasi Siswa</h4>
                    <p class="text-muted small mb-0">Sampaikan keluhan atau masukan terkait sarana dan prasarana sekolah secara cepat & transparan.</p>
                </div>
            </div>

            <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row g-3">
                    <!-- NIS -->
                    <div class="col-md-6">
                        <label for="nis" class="form-label fw-semibold">Nomor Induk Siswa (NIS) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-person-badge"></i></span>
                            <input type="number" class="form-control @error('nis') is-invalid @enderror" id="nis" name="nis" value="{{ old('nis') }}" placeholder="Contoh: 10231" required>
                            @error('nis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text small">Masukkan NIS aktif Anda.</div>
                    </div>

                    <!-- KELAS -->
                    <div class="col-md-6">
                        <label for="kelas" class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-mortarboard"></i></span>
                            <input type="text" class="form-control @error('kelas') is-invalid @enderror" id="kelas" name="kelas" value="{{ old('kelas') }}" placeholder="Contoh: XII RPL 1" required>
                            @error('kelas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text small">Contoh: X RPL 2, XI TKJ 1, XII MM 3.</div>
                    </div>

                    <!-- KATEGORI SARANA -->
                    <div class="col-12">
                        <label for="id_kategori" class="form-label fw-semibold">Kategori Sarana & Prasarana <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-tags"></i></span>
                            <select class="form-select @error('id_kategori') is-invalid @enderror" id="id_kategori" name="id_kategori" required>
                                <option value="" selected disabled>-- Pilih Kategori Sarana --</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id_kategori }}" {{ old('id_kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                                        {{ $kategori->ket_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- LOKASI -->
                    <div class="col-12">
                        <label for="lokasi" class="form-label fw-semibold">Lokasi Sarana <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-geo-alt"></i></span>
                            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi') }}" placeholder="Contoh: Lab Komputer 2, Kelas XII RPL 1, Toilet Lantai 2" required>
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- KETERANGAN PENGADUAN -->
                    <div class="col-12">
                        <label for="ket" class="form-label fw-semibold">Keterangan / Rincian Masukan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('ket') is-invalid @enderror" id="ket" name="ket" rows="4" placeholder="Jelaskan secara detail kerusakan atau sarana yang membutuhkan penanganan..." required>{{ old('ket') }}</textarea>
                        @error('ket')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- FOTO LAMPIRAN (OPSIONAL) -->
                    <div class="col-12">
                        <label for="foto" class="form-label fw-semibold">Lampiran Bukti Foto <span class="text-muted fw-normal">(Opsional)</span></label>
                        <div class="input-group">
                            <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text small">Format didukung: JPG, PNG, WEBP (Maksimal 2 MB).</div>
                    </div>

                    <!-- TOMBOL SUBMIT -->
                    <div class="col-12 pt-2">
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-send-fill"></i> Kirim Aspirasi Sekarang
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Kolom Kanan: Panduan & Cek Cepat Histori -->
    <div class="col-lg-5">
        <!-- Card Cek Histori Cepat -->
        <div class="card card-custom bg-white p-4 mb-4 border-start border-primary border-4">
            <h5 class="fw-bold text-dark mb-2"><i class="bi bi-search me-1 text-primary"></i> Cek Status Pengaduan</h5>
            <p class="text-muted small">Sudah pernah mengirim pengaduan? Masukkan NIS Anda untuk melacak progres perbaikan dan umpan balik admin.</p>
            <form action="{{ route('siswa.histori') }}" method="GET" class="d-flex gap-2">
                <input type="number" name="nis" class="form-control" placeholder="Masukkan NIS Anda..." required>
                <button type="submit" class="btn btn-outline-primary px-3">
                    <i class="bi bi-arrow-right"></i>
                </button>
            </form>
        </div>

        <!-- Card Alur Prosedur -->
        <div class="card card-custom bg-white p-4 mb-4">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-info-circle me-1 text-primary"></i> Alur Penanganan Sarana</h5>
            <div class="d-flex flex-column gap-3">
                <div class="d-flex align-items-start gap-3">
                    <div class="step-circle step-inactive bg-light text-primary border border-primary fs-6">1</div>
                    <div>
                        <div class="fw-semibold text-dark">Kirim Pengaduan</div>
                        <div class="text-muted small">Siswa mengisi form dengan NIS, lokasi, dan penjelasan kerusakan sarana.</div>
                    </div>
                </div>
                <div class="d-flex align-items-start gap-3">
                    <div class="step-circle step-inactive bg-light text-warning border border-warning fs-6">2</div>
                    <div>
                        <div class="fw-semibold text-dark">Verifikasi & Penjadwalan</div>
                        <div class="text-muted small">Admin/Teknisi memverifikasi lokasi dan menjadwalkan perbaikan (Status: Menunggu/Proses).</div>
                    </div>
                </div>
                <div class="d-flex align-items-start gap-3">
                    <div class="step-circle step-inactive bg-light text-success border border-success fs-6">3</div>
                    <div>
                        <div class="fw-semibold text-dark">Penyelesaian & Umpan Balik</div>
                        <div class="text-muted small">Sarana telah diperbaiki, admin memberikan laporan umpan balik (Status: Selesai).</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Pengaduan Terkini -->
        <div class="card card-custom bg-white p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-activity me-1 text-primary"></i> Laporan Terkini</h5>
                <span class="badge bg-light text-muted fw-normal">{{ $recentAspirasis->count() }} Terkini</span>
            </div>
            @if($recentAspirasis->isEmpty())
                <p class="text-muted small mb-0 text-center py-3">Belum ada pengaduan sarana yang masuk.</p>
            @else
                <div class="list-group list-group-flush">
                    @foreach($recentAspirasis as $item)
                    <div class="list-group-item px-0 py-2 border-bottom">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="fw-semibold text-dark small d-block">{{ $item->inputAspirasi->lokasi ?? 'Lokasi tidak tersedia' }}</span>
                                <span class="text-muted small" style="font-size: 0.75rem;">
                                    {{ $item->kategori->ket_kategori ?? '-' }} &bull; {{ $item->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <span class="badge badge-status 
                                @if($item->status == 'Menunggu') badge-menunggu 
                                @elseif($item->status == 'Proses') badge-proses 
                                @else badge-selesai @endif" style="font-size: 0.75rem;">
                                {{ $item->status }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
