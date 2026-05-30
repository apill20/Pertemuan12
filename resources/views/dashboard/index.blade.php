@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h3 class="border-bottom pb-2">
            <i class="bi bi-speedometer2 text-primary"></i> Dashboard Perpustakaan
        </h3>
    </div>
</div>

{{-- Quick Links Menu Utama --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-light border-0 shadow-sm">
            <div class="card-body py-3 d-flex align-items-center">
                <strong class="me-3">Quick Links:</strong>
                <a href="{{ route('home') }}" class="btn btn-sm btn-info text-white me-2"><i class="bi bi-house"></i> Home</a>
                <a href="{{ route('buku.index') }}" class="btn btn-sm btn-primary me-2"><i class="bi bi-book"></i> Kelola Buku</a>
                <a href="{{ route('anggota.index') }}" class="btn btn-sm btn-success me-2"><i class="bi bi-people"></i> Kelola Anggota</a>
            </div>
        </div>
    </div>
</div>

{{-- Card Statistik --}}
<div class="row mb-4">
    {{-- Statistik Buku --}}
    <div class="col-md-6 mb-3 mb-md-0">
        <div class="card border-primary h-100 shadow-sm">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-journals"></i> Ringkasan Buku
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4 border-end">
                        <h2 class="text-primary mb-0">{{ $totalBuku }}</h2>
                        <small class="text-muted">Total Buku</small>
                    </div>
                    <div class="col-4 border-end">
                        <h2 class="text-success mb-0">{{ $bukuTersedia }}</h2>
                        <small class="text-muted">Tersedia</small>
                    </div>
                    <div class="col-4">
                        <h2 class="text-danger mb-0">{{ $bukuHabis }}</h2>
                        <small class="text-muted">Habis</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Statistik Anggota --}}
    <div class="col-md-6">
        <div class="card border-success h-100 shadow-sm">
            <div class="card-header bg-success text-white">
                <i class="bi bi-people-fill"></i> Ringkasan Anggota
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4 border-end">
                        <h2 class="text-success mb-0">{{ $totalAnggota }}</h2>
                        <small class="text-muted">Total Anggota</small>
                    </div>
                    <div class="col-4 border-end">
                        <h2 class="text-primary mb-0">{{ $anggotaAktif }}</h2>
                        <small class="text-muted">Aktif</small>
                    </div>
                    <div class="col-4">
                        <h2 class="text-secondary mb-0">{{ $anggotaNonaktif }}</h2>
                        <small class="text-muted">Nonaktif</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- List Data Terbaru --}}
<div class="row">
    {{-- 5 Buku Terbaru --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history"></i> 5 Buku Terbaru</span>
                <a href="{{ route('buku.index') }}" class="btn btn-sm btn-outline-light" style="padding: 0.1rem 0.5rem; font-size: 0.8rem;">Lihat Semua</a>
            </div>
            <ul class="list-group list-group-flush">
                @forelse($bukuTerbaru as $buku)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">{{ $buku->judul }}</h6>
                            <small class="text-muted">{{ $buku->pengarang }}</small>
                        </div>
                        <span class="badge bg-{{ $buku->stok > 0 ? 'success' : 'danger' }} rounded-pill">
                            {{ $buku->stok }} stok
                        </span>
                    </li>
                @empty
                    <li class="list-group-item text-muted text-center py-4">Belum ada data buku.</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- 5 Anggota Terbaru --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <span><i class="bi bi-person-plus-fill"></i> 5 Anggota Terbaru</span>
                <a href="{{ route('anggota.index') }}" class="btn btn-sm btn-outline-light" style="padding: 0.1rem 0.5rem; font-size: 0.8rem;">Lihat Semua</a>
            </div>
            <ul class="list-group list-group-flush">
                @forelse($anggotaTerbaru as $anggota)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">{{ $anggota->nama }}</h6>
                            <small class="text-muted">{{ $anggota->email }}</small>
                        </div>
                        <span class="badge bg-{{ strtolower($anggota->status) == 'aktif' ? 'primary' : 'secondary' }}">
                            {{ $anggota->status }}
                        </span>
                    </li>
                @empty
                    <li class="list-group-item text-muted text-center py-4">Belum ada data anggota.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection