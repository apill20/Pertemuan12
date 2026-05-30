<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. Ambil semua data buku dari database
        $bukus = Buku::latest()->get();
        
        // 2. Data Unik untuk Dropdown Form Advanced Search (Tugas 3)
        $kategoris = Buku::select('kategori')->distinct()->pluck('kategori');
        $tahuns = Buku::select('tahun_terbit')->distinct()->pluck('tahun_terbit')->sortDesc();
        
        // 3. Statistik Lama Tetap Dipertahankan
        $totalBuku = Buku::count();
        $bukuTersedia = Buku::where('stok', '>', 0)->count();
        $bukuHabis = Buku::where('stok', 0)->count();
        
        // Return view dengan gabungan data lama + baru
        return view('buku.index', compact(
            'bukus',
            'kategoris',
            'tahuns',
            'totalBuku',
            'bukuTersedia',
            'bukuHabis'
        ));
    }

    /**
     * Fitur Pencarian & Filter Advanced (Tugas 3)
     */
    public function search(Request $request)
    {
        $query = Buku::query();
        
        // Filter Keyword (mencari di judul, pengarang, penerbit)
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%")
                  ->orWhere('pengarang', 'like', "%{$keyword}%")
                  ->orWhere('penerbit', 'like', "%{$keyword}%");
            });
        }

        // Filter Kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter Tahun
        if ($request->filled('tahun')) {
            $query->where('tahun_terbit', $request->tahun);
        }

        // Filter Ketersediaan
        if ($request->filled('ketersediaan')) {
            if ($request->ketersediaan == 'Tersedia') {
                $query->where('stok', '>', 0);
            } elseif ($request->ketersediaan == 'Habis') {
                $query->where('stok', '<=', 0);
            }
        }
        
        // Eksekusi query hasil pencarian
        $bukus = $query->latest()->get();
        
        // Ambil data dropdown agar form pencarian tidak kosong/error
        $kategoris = Buku::select('kategori')->distinct()->pluck('kategori');
        $tahuns = Buku::select('tahun_terbit')->distinct()->pluck('tahun_terbit')->sortDesc();

        // Hitung ulang statistik berdasarkan hasil pencarian saat ini
        $totalBuku = $bukus->count();
        $bukuTersedia = $bukus->where('stok', '>', 0)->count();
        $bukuHabis = $bukus->where('stok', 0)->count();

        return view('buku.index', compact(
            'bukus', 
            'kategoris', 
            'tahuns', 
            'totalBuku', 
            'bukuTersedia', 
            'bukuHabis'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('buku.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Akan diimplementasi di pertemuan 12 sesuai modul utama
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.show', compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.edit', compact('buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Akan diimplementasi di pertemuan 12 sesuai modul utama
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Akan diimplementasi di pertemuan 12 sesuai modul utama
    }
    
    /**
     * Filter buku berdasarkan kategori (Rute Kustom Lama)
     */
    public function filterKategori($kategori)
    {
        $bukus = Buku::where('kategori', $kategori)->latest()->get();
        
        // Ditambahkan data dropdown agar layout indeks baru tidak jebol/error
        $kategoris = Buku::select('kategori')->distinct()->pluck('kategori');
        $tahuns = Buku::select('tahun_terbit')->distinct()->pluck('tahun_terbit')->sortDesc();

        $totalBuku = $bukus->count();
        $bukuTersedia = $bukus->where('stok', '>', 0)->count();
        $bukuHabis = $bukus->where('stok', 0)->count();
        
        return view('buku.index', compact(
            'bukus',
            'kategoris',
            'tahuns',
            'totalBuku',
            'bukuTersedia',
            'bukuHabis',
            'kategori'
        ));
    }
}