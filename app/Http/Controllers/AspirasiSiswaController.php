<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Kategori;
use App\Models\Siswa;
use App\Models\InputAspirasi;
use App\Models\Aspirasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AspirasiSiswaController extends Controller
{
    /**
     * Halaman Utama: Form Pengaduan Aspirasi Sarana Sekolah
     */
    public function index()
    {
        $kategoris = Kategori::orderBy('ket_kategori', 'asc')->get();
        $recentAspirasis = Aspirasi::with(['inputAspirasi.siswa', 'kategori'])
            ->latest()
            ->take(5)
            ->get();

        return view('siswa.form_aspirasi', compact('kategoris', 'recentAspirasis'));
    }

    /**
     * Menyimpan data pengaduan baru dari Siswa
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => ['required', 'numeric', 'digits_between:4,10'],
            'kelas' => ['required', 'string', 'max:10'],
            'id_kategori' => ['required', 'exists:kategori,id_kategori'],
            'lokasi' => ['required', 'string', 'max:50'],
            'ket' => ['required', 'string', 'max:500'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'nis.required' => 'NIS wajib diisi.',
            'nis.numeric' => 'NIS harus berupa angka.',
            'nis.digits_between' => 'NIS harus antara 4 hingga 10 digit.',
            'kelas.required' => 'Kelas wajib diisi.',
            'kelas.max' => 'Kelas maksimal 10 karakter.',
            'id_kategori.required' => 'Silakan pilih kategori sarana.',
            'id_kategori.exists' => 'Kategori yang dipilih tidak valid.',
            'lokasi.required' => 'Lokasi sarana yang diadukan wajib diisi.',
            'lokasi.max' => 'Lokasi maksimal 50 karakter.',
            'ket.required' => 'Keterangan pengaduan wajib diisi.',
            'ket.max' => 'Keterangan maksimal 500 karakter.',
            'foto.image' => 'File foto harus berupa gambar.',
            'foto.mimes' => 'Format foto yang didukung: jpg, jpeg, png, webp.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        // Gunakan DB Transaction untuk menjamin konsistensi data
        $aspirasi = DB::transaction(function () use ($request, $validated) {
            // 1. Simpan atau perbarui data Siswa
            Siswa::updateOrCreate(
                ['nis' => $validated['nis']],
                ['kelas' => strtoupper($validated['kelas'])]
            );

            // 2. Upload foto jika ada
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('aspirasi', 'public');
            }

            // 3. Simpan ke tabel input_aspirasi
            $inputAspirasi = InputAspirasi::create([
                'nis' => $validated['nis'],
                'id_kategori' => $validated['id_kategori'],
                'lokasi' => $validated['lokasi'],
                'ket' => $validated['ket'],
                'foto' => $fotoPath,
            ]);

            // 4. Buat record aspirasi dengan status awal 'Menunggu'
            return Aspirasi::create([
                'id_pelaporan' => $inputAspirasi->id_pelaporan,
                'status' => 'Menunggu',
                'id_kategori' => $validated['id_kategori'],
                'feedback' => null,
            ]);
        });

        return redirect()->route('siswa.histori', ['nis' => $validated['nis']])
            ->with('success', 'Aspirasi Anda berhasil dikirim! Kode Pelaporan: #' . $aspirasi->id_pelaporan);
    }

    /**
     * Halaman Histori Aspirasi Siswa & Tracking Progres Penyelesaian
     */
    public function histori(Request $request)
    {
        $nis = $request->query('nis');
        $aspirasis = collect();
        $siswa = null;

        if ($nis) {
            $siswa = Siswa::find($nis);

            $aspirasis = Aspirasi::with(['inputAspirasi.kategori', 'kategori'])
                ->whereHas('inputAspirasi', function ($q) use ($nis) {
                    $q->where('nis', $nis);
                })
                ->latest()
                ->paginate(10)
                ->withQueryString();
        }

        return view('siswa.histori_aspirasi', compact('aspirasis', 'nis', 'siswa'));
    }

    /**
     * Detail Aspirasi dan Progres Perbaikan untuk Siswa
     */
    public function detail($id)
    {
        $aspirasi = Aspirasi::with(['inputAspirasi.siswa', 'kategori'])
            ->findOrFail($id);

        return view('siswa.detail_aspirasi', compact('aspirasi'));
    }
}
