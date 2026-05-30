<div>
    <div class="card h-100 shadow-sm border-{{ $buku->stok > 0 ? 'primary' : 'danger' }}">
    {{-- Cover Icon (Sebagai pengganti gambar) --}}
    <div class="card-img-top bg-light text-center py-4 text-{{ $buku->stok > 0 ? 'primary' : 'danger' }}">
        <i class="bi bi-book" style="font-size: 4rem;"></i>
    </div>
    
    <div class="card-body">
        {{-- Badge Kategori & Ketersediaan --}}
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="badge bg-info text-dark">{{ $buku->kategori }}</span>
            @if($buku->stok > 0)
                <span class="badge bg-success"><i class="bi bi-check-circle"></i> Tersedia</span>
            @else
                <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Habis</span>
            @endif
        </div>

        {{-- Info Buku --}}
        <h5 class="card-title fw-bold text-truncate" title="{{ $buku->judul }}">
            {{ $buku->judul }}
        </h5>
        <p class="card-text text-muted small mb-2">
            <i class="bi bi-person"></i> {{ $buku->pengarang }}
        </p>
        <p class="card-text fw-bold text-success mb-3">
            {{ $buku->harga_format ?? 'Rp ' . number_format($buku->harga, 0, ',', '.') }}
        </p>
        <p class="card-text small mb-3">
            Stok: <strong>{{ $buku->stok }}</strong>
        </p>
    </div>

    {{-- Tombol Aksi (Hanya muncul jika $showActions = true) --}}
    @if($showActions)
        <div class="card-footer bg-transparent border-top-0 d-grid gap-2">
            <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-eye"></i> Detail
            </a>
            <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil"></i> Edit
            </a>
        </div>
    @endif
</div>
</div>