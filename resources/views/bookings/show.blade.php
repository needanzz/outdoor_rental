@extends('layouts.limitless')

@section('title', 'Detail Pesanan #' . $booking->id)

@section('content')

<div class="row">
    
    {{-- INFO USER & STATUS --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-white header-elements-inline">
                <h6 class="card-title font-weight-semibold">
                    <i class="icon-user mr-2"></i> Informasi Penyewa
                </h6>
            </div>

            <div class="card-body">
                <div class="media mb-3">
                    <div class="mr-3">
                        <a href="#">
                            <img src="{{ asset('limitless/global_assets/images/placeholders/placeholder.jpg') }}" width="40" height="40" class="rounded-circle" alt="">
                        </a>
                    </div>
                    <div class="media-body">
                        <h6 class="media-title font-weight-semibold">{{ $booking->user->name }}</h6>
                        <span class="text-muted">{{ $booking->user->email }}</span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-borderless table-xs">
                        <tbody>
                            <tr>
                                <td><i class="icon-calendar3 mr-2"></i> Tgl Order:</td>
                                <td class="text-right">{{ $booking->created_at->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <td><i class="icon-price-tag mr-2"></i> Status:</td>
                                <td class="text-right">
                                    @if($booking->status == 'active')
                                        <span class="badge badge-success">Sedang Dipinjam</span>
                                    @elseif($booking->status == 'pending')
                                        <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                    @elseif($booking->status == 'completed')
                                        <span class="badge badge-secondary">Selesai (Dikembalikan)</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- TOMBOL AKSI CEPAT --}}
                <div class="mt-4">
                    @if($booking->status == 'pending')
                        <a href="{{ route('bookings.approve', $booking->id) }}" class="btn btn-success btn-block">
                            <i class="icon-checkmark-circle mr-2"></i> Setujui Pesanan
                        </a>
                    @elseif($booking->status == 'active')
                        <a href="{{ route('bookings.complete', $booking->id) }}" class="btn btn-warning btn-block">
                            <i class="icon-spinner11 mr-2"></i> Proses Pengembalian
                        </a>
                    @endif
                    
                    {{-- Tombol Hapus (SweetAlert Trigger) --}}
                    <button data-id="{{ $booking->id }}" class="btn btn-outline-danger btn-block mt-2 delete-booking-detail">
                        <i class="icon-trash mr-2"></i> Hapus Pesanan
                    </button>
                </div>
            </div>
        </div>
    </div>


    {{-- DETAIL BARANG & HARGA --}}
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-transparent header-elements-inline">
                <h6 class="card-title font-weight-semibold">Rincian Sewa</h6>
                <div class="header-elements">
                    <span class="text-muted">ID Transaksi: <strong>#TRX-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</strong></span>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $booking->item->image) }}" class="img-fluid rounded" alt="" style="max-height: 200px; width: 100%; object-fit: cover;">
                        </div>
                    </div>

                    <div class="col-sm-8">
                        <h4 class="font-weight-bold">{{ $booking->item->name }}</h4>
                        <p class="text-muted mb-3">{{ $booking->item->description }}</p>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-muted">Tanggal Mulai:</label>
                                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($booking->start_date)->format('d F Y') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-muted">Tanggal Selesai:</label>
                                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($booking->end_date)->format('d F Y') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-lg">
                    <thead>
                        <tr>
                            <th>Deskripsi</th>
                            <th>Harga Satuan</th>
                            <th>Durasi</th>
                            <th>Jumlah</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <span class="font-weight-semibold">{{ $booking->item->name }}</span>
                            </td>
                            <td>Rp {{ number_format($booking->item->price, 0, ',', '.') }}</td>
                            <td>
                                <?php 
                                    $start = \Carbon\Carbon::parse($booking->start_date);
                                    $end = \Carbon\Carbon::parse($booking->end_date);
                                    $days = $start->diffInDays($end) + 1;
                                ?>
                                {{ $days }} Hari
                            </td>
                            <td>{{ $booking->quantity }} Unit</td>
                            <td class="text-right">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card-body bg-light border-top">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('bookings.index') }}" class="btn btn-light"><i class="icon-arrow-left52 mr-2"></i> Kembali</a>
                    
                    <div class="text-right">
                        <span class="text-muted">Total Tagihan:</span>
                        <h3 class="font-weight-bold text-primary mb-0">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Logic Hapus Khusus Halaman Detail
    $('.delete-booking-detail').on('click', function () {
        var id = $(this).data("id");
        
        Swal.fire({
            title: 'Hapus Pesanan?',
            text: "Data ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('bookings.index') }}" + '/' + id,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
                        Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success').then(() => {
                            window.location.href = "{{ route('bookings.index') }}";
                        });
                    },
                    error: function (data) {
                        Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
                    }
                });
            }
        });
    });
</script>
@endsection