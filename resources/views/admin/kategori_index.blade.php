@extends('layouts.app')

@section('title', 'Kelola Master Kategori Sarana')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm mb-2">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
                <h4 class="fw-bold text-dark mb-0">Master Kategori Sarana Sekolah</h4>
            </div>
        </div>

        <div class="row g-4">
            <!-- Form Tambah Kategori -->
            <div class="col-md-4">
                <div class="card card-custom bg-white p-4">
                    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-plus-circle text-primary me-2"></i>Tambah Kategori</h5>
                    <form action="{{ route('admin.kategori.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="ket_kategori" class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" name="ket_kategori" id="ket_kategori" class="form-control @error('ket_kategori') is-invalid @enderror" placeholder="Contoh: Sarana Lab IPA" value="{{ old('ket_kategori') }}" required>
                            @error('ket_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text small">Maksimal 30 karakter.</div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-semibold">
                            <i class="bi bi-save me-1"></i> Simpan Kategori
                        </button>
                    </form>
                </div>
            </div>

            <!-- Tabel Daftar Kategori -->
            <div class="col-md-8">
                <div class="card card-custom bg-white overflow-hidden">
                    <div class="card-header bg-white py-3">
                        <h6 class="fw-bold text-dark mb-0">Daftar Kategori Sarana</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-secondary small text-uppercase">
                                <tr>
                                    <th class="ps-3" style="width: 70px;">ID</th>
                                    <th>Nama Kategori</th>
                                    <th class="text-center" style="width: 140px;">Jumlah Aspirasi</th>
                                    <th class="text-center pe-3" style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kategoris as $kategori)
                                <tr>
                                    <td class="ps-3 fw-bold text-muted">#{{ $kategori->id_kategori }}</td>
                                    <td class="fw-semibold text-dark">{{ $kategori->ket_kategori }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-primary border px-2 py-1">
                                            {{ $kategori->aspirasi_count }} Laporan
                                        </span>
                                    </td>
                                    <td class="text-center pe-3">
                                        <form action="{{ route('admin.kategori.destroy', $kategori->id_kategori) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada kategori yang terdaftar.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
