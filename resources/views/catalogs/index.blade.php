@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 mb-4">
            <h2>Katalog Alat Camping ⛺</h2>
            <p>Pilih alat terbaik untuk petualanganmu!</p>
        </div>
    </div>

    <div class="row">
        @foreach($items as $item)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                {{-- Gambar Barang --}}
                <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->name }}" style="height: 350px; object-fit: cover;">
                
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    <p class="card-text text-muted">
                        {{ Str::limit($item->description, 80) }}
                    </p>
                    
                    <div class="mt-auto">
                        <h5 class="text-primary mb-3">Rp {{ number_format($item->price, 0, ',', '.') }} / hari</h5>
                        
                        {{-- LOGIKA HITUNG STOK REAL-TIME --}}
                        @php
                            // Sisa = Total Aset - Sedang Dipinjam Hari Ini
                            $available_stock = $item->stock - $item->rented_count;
                        @endphp

                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <span class="badge {{ $available_stock > 0 ? 'badge-info' : 'badge-danger' }}">
                                Stok Tersedia: {{ $available_stock }}
                            </span>
                            
                            @if($available_stock > 0)
                                {{-- JIKA SUDAH LOGIN --}}
                                @auth
                                    <a href="{{ route('bookings.create', $item->id) }}" class="btn btn-success btn-sm">Sewa Sekarang</a>
                                
                                {{-- JIKA BELUM LOGIN (TAMU) --}}
                                @else
                                    <button type="button" class="btn btn-secondary btn-sm btn-guest-rent">
                                        Sewa Sekarang
                                    </button>   
                                @endguest
                            @else
                                <button class="btn btn-secondary btn-sm" disabled>Habis</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const guestButtons = document.querySelectorAll('.btn-guest-rent');

        guestButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Eits! Belum Login 🔒',
                    text: "Kamu harus Login atau Register dulu untuk menyewa barang keren ini. Mau login sekarang?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Login!',
                    cancelButtonText: 'Lihat-lihat Dulu',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('login') }}";
                    }
                });
            });
        });
    });
</script>
@endsection