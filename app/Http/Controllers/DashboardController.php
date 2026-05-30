<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Anggota;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Buku
        $totalBuku = Buku::count();
        $bukuTersedia = Buku::where('stok', '>', 0)->count();
        $bukuHabis = Buku::where('stok', '<=', 0)->count();

        // 2. Statistik Anggota
        // (Asumsi kolom status bernama 'status' dan isinya 'Aktif' / 'Nonaktif')
        $totalAnggota = Anggota::count();
        $anggotaAktif = Anggota::where('status', 'Aktif')->count();
        $anggotaNonaktif = Anggota::where('status', '!=', 'Aktif')->count();

        // 3. Ambil 5 Data Terbaru
        $bukuTerbaru = Buku::latest()->take(5)->get();
        $anggotaTerbaru = Anggota::latest()->take(5)->get();

        // Lempar semua variabel ke View
        return view('dashboard.index', compact(
            'totalBuku', 'bukuTersedia', 'bukuHabis',
            'totalAnggota', 'anggotaAktif', 'anggotaNonaktif',
            'bukuTerbaru', 'anggotaTerbaru'
        ));
    }
}