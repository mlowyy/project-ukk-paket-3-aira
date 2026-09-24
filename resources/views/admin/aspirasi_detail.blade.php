@extends('layouts.app')

@section('title', 'Detail Aspirasi Sarana #' . ($aspirasi->inputAspirasi->id_pelaporan ?? $aspirasi->id_aspirasi))

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm mb-2">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
                <h4 class="fw-bold text-dark mb-0">Detail Aspirasi Pengaduan Sarana</h4>
            </div>
            <span class="badge badge-status 
                @if($aspirasi->status == 'Menunggu') badge-menunggu 
                @elseif($aspirasi->status == 'Proses') badge-proses 
                @else badge-selesai @endif fs-6">
                Status: {{ $aspirasi->status }}
            </span>
        </div>

        <div class="row g-4">
            <!-- Kolom Kiri: Rincian Pengaduan Siswa -->
            <div class="col-md-7">
                <div class="card card-custom bg-white p-4 h-100">
                    <h5 class="fw-bold text-dark border-bottom pb-3 mb-3">
                        <i class="bi bi-file-earmark-text text-primary me-2"></i>Rincian Pengaduan
                    </h5>

                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <th style="width: 150px;" class="text-muted fw-semibold">ID Pelaporan</th>
                                <td class="fw-bold text-dark">#PELAPORAN-{{ $aspirasi->inputAspirasi->id_pelaporan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-semibold">Tanggal Kirim</th>
                                <td class="text-dark">{{ $aspirasi->created_at->format('d F Y, H:i') }} WIB ({{ $aspirasi->created_at->diffForHumans() }})</td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-semibold">NIS Pelapor</th>
                                <td class="text-dark fw-bold">{{ $aspirasi->inputAspirasi->nis ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-semibold">Kelas</th>
                                <td><span class="badge bg-light text-primary border">{{ $aspirasi->inputAspirasi->siswa->kelas ?? '-' }}</span></td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-semibold">Kategori Sarana</th>
                                <td class="text-dark">{{ $aspirasi->kategori->ket_kategori ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-semibold">Lokasi Sarana</th>
                                <td class="text-dark fw-semibold"><i class="bi bi-geo-alt text-danger me-1"></i>{{ $aspirasi->inputAspirasi->lokasi ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-semibold align-top">Keterangan</th>
                                <td class="text-dark">
                                    <div class="p-3 bg-light rounded">{{ $aspirasi->inputAspirasi->ket ?? '-' }}</div>
                                </td>
                            </tr>
                            @if(optional($aspirasi->inputAspirasi)->foto)
                            <tr>
                                <th class="text-muted fw-semibold align-top">Lampiran Foto</th>
                                <td>
                                    <a href="{{ asset('storage/' . $aspirasi->inputAspirasi->foto) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $aspirasi->inputAspirasi->foto) }}" alt="Foto Sarana" class="img-thumbnail" style="max-height: 220px; border-radius: 8px;">
                                    </a>
                                    <div class="form-text small">Klik gambar untuk memperbesar.</div>
                                </td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Form Umpan Balik & Status -->
            <div class="col-md-5">
                <div class="card card-custom bg-white p-4 h-100">
                    <h5 class="fw-bold text-dark border-bottom pb-3 mb-3">
                        <i class="bi bi-chat-left-dots text-primary me-2"></i>Form Umpan Balik
                    </h5>

                    <form action="{{ route('admin.aspirasi.update', $aspirasi->id_aspirasi) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="status" class="form-label fw-semibold">Status Penyelesaian <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="Menunggu" {{ old('status', $aspirasi->status) == 'Menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                <option value="Proses" {{ old('status', $aspirasi->status) == 'Proses' ? 'selected' : '' }}>Proses (Dalam Penanganan)</option>
                                <option value="Selesai" {{ old('status', $aspirasi->status) == 'Selesai' ? 'selected' : '' }}>Selesai (Tuntas)</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="feedback" class="form-label fw-semibold">Umpan Balik (Feedback)</label>
                            <textarea name="feedback" id="feedback" rows="6" class="form-control @error('feedback') is-invalid @enderror" placeholder="Ketik keterangan umpan balik, langkah perbaikan, atau catatan untuk siswa...">{{ old('feedback', $aspirasi->feedback) }}</textarea>
                            @error('feedback')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text small">Umpan balik ini dapat langsung dilihat oleh siswa yang melapor saat mengecek histori.</div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold mb-2">
                            <i class="bi bi-save me-1"></i> Perbarui Status & Umpan Balik
                        </button>
                    </form>

                    <hr>

                    <!-- Hapus Aspirasi -->
                    <form action="{{ route('admin.aspirasi.destroy', $aspirasi->id_aspirasi) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pengaduan ini secara permanen?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100 btn-sm">
                            <i class="bi bi-trash me-1"></i> Hapus Pengaduan Ini
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
