@extends('layouts.app')

@section('title', 'Histori & Status Pengaduan Sarana')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Search Bar Header -->
        <div class="card card-custom bg-white p-4 mb-4 text-center">
            <h4 class="fw-bold text-dark mb-2"><i class="bi bi-clock-history text-primary me-2"></i>Histori Pengaduan Sarana</h4>
            <p class="text-muted small mb-4">Cek status penyelesaian, progres perbaikan, dan umpan balik dari pihak sekolah berdasarkan NIS Anda.</p>
            
            <form action="{{ route('siswa.histori') }}" method="GET" class="row g-2 justify-content-center">
                <div class="col-md-6 col-sm-8">
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-person-badge"></i></span>
                        <input type="number" name="nis" class="form-control form-control-lg" placeholder="Masukkan NIS Siswa (Contoh: 10231)..." value="{{ $nis }}" required>
                        <button type="submit" class="btn btn-primary px-4 fw-semibold">
                            <i class="bi bi-search me-1"></i> Cari Histori
                        </button>
                    </div>
                </div>
            </form>
            @if(!$nis)
            <div class="mt-3">
                <span class="text-muted small">Contoh NIS untuk uji coba: </span>
                <a href="{{ route('siswa.histori', ['nis' => 10231]) }}" class="badge bg-light text-primary border text-decoration-none me-1">10231</a>
                <a href="{{ route('siswa.histori', ['nis' => 10232]) }}" class="badge bg-light text-primary border text-decoration-none me-1">10232</a>
                <a href="{{ route('siswa.histori', ['nis' => 10233]) }}" class="badge bg-light text-primary border text-decoration-none">10233</a>
            </div>
            @endif
        </div>

        @if($nis)
            <!-- Info Siswa -->
            @if($siswa)
            <div class="card card-custom bg-primary text-white p-3 mb-4 d-flex flex-row justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-white text-primary p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="bi bi-person-fill fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">Siswa NIS: {{ $siswa->nis }}</h6>
                        <span class="small opacity-75">Kelas: {{ $siswa->kelas }}</span>
                    </div>
                </div>
                <div>
                    <span class="badge bg-white text-primary px-3 py-2 fw-semibold">Total {{ $aspirasis->total() }} Pengaduan</span>
                </div>
            </div>
            @endif

            <!-- List Aspirasi -->
            @if($aspirasis->isEmpty())
                <div class="card card-custom bg-white p-5 text-center">
                    <i class="bi bi-inbox text-muted display-4 mb-3"></i>
                    <h5 class="fw-bold text-dark">Belum Ada Pengaduan Ditemukan</h5>
                    <p class="text-muted">Tidak ditemukan histori pengaduan sarana dengan NIS <strong>{{ $nis }}</strong>.</p>
                    <div>
                        <a href="{{ route('siswa.form') }}" class="btn btn-outline-primary">
                            <i class="bi bi-pencil-square me-1"></i> Buat Pengaduan Sekarang
                        </a>
                    </div>
                </div>
            @else
                <div class="d-flex flex-column gap-4">
                    @foreach($aspirasis as $item)
                    <div class="card card-custom bg-white p-4">
                        <div class="d-flex flex-wrap justify-content-between align-items-center border-bottom pb-3 mb-3 gap-2">
                            <div>
                                <span class="badge bg-light text-dark border me-2">#PELAPORAN-{{ $item->inputAspirasi->id_pelaporan ?? $item->id_pelaporan }}</span>
                                <span class="text-muted small"><i class="bi bi-calendar-event me-1"></i> {{ $item->created_at->format('d M Y, H:i') }} WIB</span>
                            </div>
                            <span class="badge badge-status 
                                @if($item->status == 'Menunggu') badge-menunggu 
                                @elseif($item->status == 'Proses') badge-proses 
                                @else badge-selesai @endif fs-6">
                                <i class="bi 
                                    @if($item->status == 'Menunggu') bi-hourglass-split 
                                    @elseif($item->status == 'Proses') bi-gear-wide-connected 
                                    @else bi-check-circle-fill @endif me-1"></i>
                                Status: {{ $item->status }}
                            </span>
                        </div>

                        <!-- Info Sarana & Kerusakan -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="text-muted small">Kategori Sarana:</div>
                                <div class="fw-semibold text-dark">{{ $item->kategori->ket_kategori ?? '-' }}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-muted small">Lokasi Sarana:</div>
                                <div class="fw-semibold text-dark"><i class="bi bi-geo-alt text-danger me-1"></i> {{ $item->inputAspirasi->lokasi ?? '-' }}</div>
                            </div>
                            <div class="col-12">
                                <div class="text-muted small">Keterangan Pengaduan:</div>
                                <div class="p-3 bg-light rounded text-dark mt-1">{{ $item->inputAspirasi->ket ?? '-' }}</div>
                            </div>
                            @if(optional($item->inputAspirasi)->foto)
                            <div class="col-12">
                                <div class="text-muted small mb-1">Bukti Foto Sarana:</div>
                                <a href="{{ asset('storage/' . $item->inputAspirasi->foto) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $item->inputAspirasi->foto) }}" alt="Foto Sarana" class="img-thumbnail" style="max-height: 180px; border-radius: 8px;">
                                </a>
                            </div>
                            @endif
                        </div>

                        <!-- Progress Bar / Visual Progress Tracker -->
                        <div class="card bg-light border-0 p-3 mb-3">
                            <div class="fw-semibold text-dark small mb-3"><i class="bi bi-diagram-3 me-1 text-primary"></i> Progres Penanganan:</div>
                            <div class="row text-center position-relative">
                                <!-- Step 1 -->
                                <div class="col-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="step-circle step-completed mb-2">
                                            <i class="bi bi-check-lg"></i>
                                        </div>
                                        <div class="fw-bold small text-dark">1. Diterima</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">Laporan masuk</div>
                                    </div>
                                </div>
                                <!-- Step 2 -->
                                <div class="col-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="step-circle 
                                            @if($item->status == 'Proses' || $item->status == 'Selesai') step-completed 
                                            @else step-inactive @endif mb-2">
                                            @if($item->status == 'Proses' || $item->status == 'Selesai')
                                                <i class="bi bi-gear-fill"></i>
                                            @else
                                                2
                                            @endif
                                        </div>
                                        <div class="fw-bold small {{ $item->status != 'Menunggu' ? 'text-dark' : 'text-muted' }}">2. Proses Tindak Lanjut</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">Verifikasi / Perbaikan</div>
                                    </div>
                                </div>
                                <!-- Step 3 -->
                                <div class="col-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="step-circle 
                                            @if($item->status == 'Selesai') step-completed 
                                            @else step-inactive @endif mb-2">
                                            @if($item->status == 'Selesai')
                                                <i class="bi bi-check2-circle"></i>
                                            @else
                                                3
                                            @endif
                                        </div>
                                        <div class="fw-bold small {{ $item->status == 'Selesai' ? 'text-success' : 'text-muted' }}">3. Selesai</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">Sarana tuntas ditangani</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Umpan Balik Admin (Feedback) -->
                        <div class="border-top pt-3">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-chat-left-quote-fill text-primary"></i>
                                <span class="fw-bold text-dark small">Umpan Balik (Feedback) Pihak Sekolah:</span>
                            </div>
                            @if($item->feedback)
                                <div class="alert alert-info border-0 mb-0 d-flex gap-2">
                                    <i class="bi bi-info-circle-fill text-primary mt-1"></i>
                                    <div>
                                        <div class="text-dark">{{ $item->feedback }}</div>
                                        <div class="text-muted mt-1" style="font-size: 0.75rem;">Diperbarui: {{ $item->updated_at->format('d M Y, H:i') }} WIB</div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-secondary border-0 mb-0 small text-muted">
                                    <i class="bi bi-hourglass me-1"></i> Belum ada umpan balik dari tim sarana prasarana sekolah. Mohon pantau secara berkala.
                                </div>
                            @endif
                        </div>
                    </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $aspirasis->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
