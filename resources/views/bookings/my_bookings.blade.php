@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Riwayat Pesanan Saya 🛍️</div>

                <div class="card-body">
                    @if($bookings->isEmpty())
                        <div class="text-center py-4">
                            <p class="text-muted">Kamu belum pernah menyewa apapun.</p>
                            <a href="{{ route('home') }}" class="btn btn-primary">Cari Barang Dulu Yuk!</a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal Booking</th>
                                        <th>Barang</th>
                                        <th>Durasi Sewa</th>
                                        <th>Total Harga</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                    <tr>
                                        <td>{{ $booking->created_at->format('d M Y') }}</td>
                                        <td>
                                            <strong>{{ $booking->item->name }}</strong>
                                        </td>
                                        <td>
                                            {{ $booking->start_date }} <br>
                                            <small class="text-muted">s/d {{ $booking->end_date }}</small>
                                        </td>
                                        <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                        <td>
                                            @if($booking->status == 'active')
                                                <span class="badge badge-success">Sedang Dipinjam</span>
                                            @elseif($booking->status == 'completed')
                                                <span class="badge badge-secondary">Selesai</span>
                                            @else
                                                <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection