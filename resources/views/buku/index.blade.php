@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>
        <i class="bi bi-book"></i>
        Daftar Buku
    </h1>
    <a href="{{ route('buku.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Buku
    </a>
</div>

{{-- Statistik Cards (Tetap dipertahankan dari desain lamamu) --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-primary shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Buku</h6>
                        <h2 class="mb-0">{{ $totalBuku }}</h2>
                    </div>
                    <div class="text-primary">
                        <i class="bi bi-book-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-success shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Buku Tersedia</h6>
                        <h2 class="mb-0">{{ $bukuTersedia }}</h2>
                    </div>
                    <div class="text-success">
                        <i class="bi bi-check-circle-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-danger shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Buku Habis</h6>
                        <h2 class="mb-0">{{ $bukuHabis }}</h2>
                    </div>
                    <div class="text-danger">
                        <i class="bi bi-x-circle-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- FORM PENCARIAN ADVANCED (Tugas 3) --}}
{{-- Menggantikan tombol-tombol filter kategori yang lama --}}
<div class="card mb-4 shadow-sm border-0 bg-light">
    <div class="card-body">
        <form action="{{ route('buku.search') }}" method="GET" class="row g-2 align-items-center">
            {{-- Keyword --}}
            <div class="col-md-4">
                <input type="text" name="keyword" class="form-control" placeholder="Cari judul, pengarang, penerbit..." value="{{ request('keyword') }}">
            </div>
            
            {{-- Filter Kategori --}}
            <div class="col-md-3">
                <select name="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>
            
            {{-- Filter Tahun --}}
            <div class="col-md-2">
                <select name="tahun" class="form-select">
                    <option value="">Semua Tahun</option>
                    @foreach($tahuns as $thn)
                        <option value="{{ $thn }}" {{ request('tahun') == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                    @endforeach
                </select>
            </div>
            
            {{-- Filter Ketersediaan --}}
            <div class="col-md-2">
                <select name="ketersediaan" class="form-select">
                    <option value="">Status Stok</option>
                    <option value="Tersedia" {{ request('ketersediaan') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Habis" {{ request('ketersediaan') == 'Habis' ? 'selected' : '' }}>Habis</option>
                </select>
            </div>
            
            {{-- Tombol Search --}}
            <div class="col-md-1 d-grid">
                <button type="submit" class="btn btn-success"><i class="bi bi-search"></i></button>
            </div>
        </form>
    </div>
</div>

{{-- Menampilkan indikator hasil pencarian & Tombol Reset --}}
@if(request()->has('keyword') || request()->has('kategori') || request()->has('tahun') || request()->has('ketersediaan') || isset($kategori))
    <div class="alert alert-info mb-4 d-flex justify-content-between align-items-center">
        <div>
            <i class="bi bi-info-circle"></i> Menampilkan hasil pencarian.
            @isset($kategori) untuk kategori <strong>{{ $kategori }}</strong> @endisset
        </div>
        <a href="{{ route('buku.index') }}" class="btn btn-sm btn-outline-info">Reset Filter</a>
    </div>
@endif

{{-- GRID BUKU MENGGUNAKAN BLADE COMPONENT (Tugas 2) --}}
{{-- Menggantikan list vertikal yang panjang di kodelama --}}
<div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
    @forelse($bukus as $buku)
        <div class="col">
            {{-- Memanggil komponen card buku --}}
            <x-buku-card :buku="$buku" :showActions="true" />
        </div>
    @empty
        <div class="col-12 text-center py-5 w-100">
            <i class="bi bi-journal-x display-1 text-muted mb-3 d-block"></i>
            <h5 class="text-muted">Tidak ada buku yang ditemukan.</h5>
        </div>
    @endforelse
</div>

{{-- Footer Info --}}
@if ($bukus->count() > 0)
    <div class="text-center mt-4 mb-5">
        <p class="text-muted">
            Menampilkan {{ $bukus->count() }} buku
        </p>
    </div>
@endif
@endsection