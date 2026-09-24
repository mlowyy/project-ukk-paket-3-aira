<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Aspirasi;
use App\Models\InputAspirasi;
use App\Models\Kategori;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;

class AdminAspirasiController extends Controller
{
    /**
     * Halaman Dashboard Admin: List Aspirasi Keseluruhan & Filter Lengkap
     */
    public function index(Request $request)
    {
        // Query builder dengan eager loading untuk efisiensi tinggi
        $query = Aspirasi::with(['inputAspirasi.siswa', 'kategori']);

        // 1. Filter per Tanggal Spesifik
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        // 2. Filter per Bulan & Tahun
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        // 3. Filter per Siswa (NIS)
        if ($request->filled('nis')) {
            $query->whereHas('inputAspirasi', function ($q) use ($request) {
                $q->where('nis', $request->nis);
            });
        }

        // 4. Filter per Kategori
        if ($request->filled('id_kategori')) {
            $query->where('id_kategori', $request->id_kategori);
        }

        // 5. Filter per Status Penyelesaian
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 6. Pencarian kata kunci (lokasi / keterangan)
        if ($request->filled('q')) {
            $search = $request->q;
            $query->whereHas('inputAspirasi', function ($q) use ($search) {
                $q->where('lokasi', 'like', "%{$search}%")
                  ->orWhere('ket', 'like', "%{$search}%");
            });
        }

        // Statistik Ringkasan Aspirasi
        $stats = [
            'total'    => Aspirasi::count(),
            'menunggu' => Aspirasi::where('status', 'Menunggu')->count(),
            'proses'   => Aspirasi::where('status', 'Proses')->count(),
            'selesai'  => Aspirasi::where('status', 'Selesai')->count(),
        ];

        // Master Data untuk Dropdown Filter
        $kategoris = Kategori::orderBy('ket_kategori', 'asc')->get();
        $siswas = Siswa::orderBy('nis', 'asc')->get();
        $availableYears = Aspirasi::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        if ($availableYears->isEmpty()) {
            $availableYears = collect([date('Y')]);
        }

        $aspirasis = $query->latest()->paginate(10)->withQueryString();

        return view('admin.aspirasi_index', compact('aspirasis', 'stats', 'kategoris', 'siswas', 'availableYears'));
    }

    /**
     * Menampilkan detail pengaduan aspirasi
     */
    public function show($id)
    {
        $aspirasi = Aspirasi::with(['inputAspirasi.siswa', 'kategori'])->findOrFail($id);

        return view('admin.aspirasi_detail', compact('aspirasi'));
    }

    /**
     * Memperbarui status penyelesaian dan memberikan umpan balik (feedback)
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:Menunggu,Proses,Selesai'],
            'feedback' => ['nullable', 'string', 'max:1000'],
        ], [
            'status.required' => 'Status penyelesaian harus dipilih.',
            'status.in' => 'Status tidak valid.',
            'feedback.max' => 'Umpan balik maksimal 1000 karakter.',
        ]);

        $aspirasi = Aspirasi::findOrFail($id);
        $aspirasi->update([
            'status' => $validated['status'],
            'feedback' => $validated['feedback'],
        ]);

        return redirect()->back()->with('success', 'Status penyelesaian dan umpan balik berhasil diperbarui!');
    }

    /**
     * Menghapus data aspirasi
     */
    public function destroy($id)
    {
        $aspirasi = Aspirasi::findOrFail($id);
        
        // Hapus input_aspirasi yang terkait (cascade akan menghapus aspirasi juga)
        if ($aspirasi->inputAspirasi) {
            $aspirasi->inputAspirasi->delete();
        } else {
            $aspirasi->delete();
        }

        return redirect()->route('admin.dashboard')->with('success', 'Data aspirasi berhasil dihapus.');
    }

    /**
     * Cetak Rekapitulasi Laporan Pengaduan Sarana Sekolah (Print View)
     */
    public function cetak(Request $request)
    {
        $query = Aspirasi::with(['inputAspirasi.siswa', 'kategori']);

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }
        if ($request->filled('id_kategori')) {
            $query->where('id_kategori', $request->id_kategori);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $aspirasis = $query->latest()->get();

        return view('admin.cetak_laporan', compact('aspirasis'));
    }

    /**
     * Kelola Master Kategori
     */
    public function kategoriIndex()
    {
        $kategoris = Kategori::withCount('aspirasi')->orderBy('ket_kategori', 'asc')->get();
        return view('admin.kategori_index', compact('kategoris'));
    }

    /**
     * Simpan Kategori Baru
     */
    public function kategoriStore(Request $request)
    {
        $validated = $request->validate([
            'ket_kategori' => ['required', 'string', 'max:30', 'unique:kategori,ket_kategori'],
        ], [
            'ket_kategori.required' => 'Nama kategori wajib diisi.',
            'ket_kategori.max' => 'Nama kategori maksimal 30 karakter.',
            'ket_kategori.unique' => 'Kategori ini sudah ada.',
        ]);

        Kategori::create($validated);

        return redirect()->back()->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    /**
     * Hapus Kategori
     */
    public function kategoriDestroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }
}
