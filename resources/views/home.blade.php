@extends('layouts.limitless')

@section('title', 'Dashboard Utama')

@section('content')

    {{-- KARTU STATISTIK --}}
    <div class="row" id="live-stats">
        
        {{-- Card 1: Total Barang --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card card-body bg-teal-400 has-bg-image">
                <div class="media">
                    <div class="media-body">
                        <h3 class="mb-0">{{ $total_items }}</h3>
                        <span class="text-uppercase font-size-xs">Unit Barang</span>
                    </div>

                    <div class="ml-3 align-self-center">
                        <i class="icon-box icon-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 2: Total User --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card card-body bg-pink-400 has-bg-image">
                <div class="media">
                    <div class="media-body">
                        <h3 class="mb-0">{{ $total_users }}</h3>
                        <span class="text-uppercase font-size-xs">Pelanggan</span>
                    </div>

                    <div class="ml-3 align-self-center">
                        <i class="icon-users4 icon-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 3: Total Booking --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card card-body bg-orange-400 has-bg-image">
                <div class="media">
                    <div class="media-body">
                        <h3 class="mb-0">{{ $total_bookings }}</h3>
                        <span class="text-uppercase font-size-xs">Total Transaksi</span>
                    </div>

                    <div class="ml-3 align-self-center">
                        <i class="icon-cart5 icon-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 4: Pendapatan --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card card-body bg-blue-400 has-bg-image">
                <div class="media">
                    <div class="media-body">
                        {{-- Format Rupiah --}}
                        <h3 class="mb-0">Rp {{ number_format($total_income, 0, ',', '.') }}</h3>
                        <span class="text-uppercase font-size-xs">Total Pendapatan</span>
                    </div>

                    <div class="ml-3 align-self-center">
                        <i class="icon-coin-dollar icon-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- GRAFIK PENJUALAN --}}
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Grafik Pendapatan Tahun {{ date('Y') }}</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="chart-container">
                <canvas id="incomeChart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>

    {{-- TABEL ORDER TERBARU --}}
    <div class="card" id="live-table">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">5 Pesanan Terbaru</h5>
            <div class="header-elements">
                <a href="{{ route('bookings.index') }}" class="btn btn-sm btn-light">
                    <i class="icon-list mr-2"></i> Lihat Semua
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Penyewa</th>
                        <th>Barang</th>
                        <th>Jadwal Sewa</th>
                        <th>Total</th>      
                        <th>Status</th>
                        <th class="text-center"><i class="icon-menu-open2"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_bookings as $booking)
                    <tr>
                        {{-- 1. Info Penyewa --}}
                        <td>
                            <div class="font-weight-semibold">{{ $booking->user->name }}</div>
                            <span class="text-muted font-size-sm">{{ $booking->user->email }}</span>
                        </td>

                        {{-- 2. Info Barang --}}
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('storage/' . $booking->item->image) }}" class="rounded mr-2" width="40" height="40" style="object-fit: cover;" alt="">
                                <div>
                                    <a href="#" class="text-default font-weight-semibold">{{ $booking->item->name }}</a>
                                    <div class="text-muted font-size-sm">
                                        Rp {{ number_format($booking->item->price, 0, ',', '.') }} / hari
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- 3. Jadwal Sewa (Mulai - Selesai) --}}
                        <td>
                            <span class="text-default font-weight-semibold">
                                {{ \Carbon\Carbon::parse($booking->start_date)->format('d M') }} 
                                - 
                                {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}
                            </span>
                        </td>

                        {{-- 4. Total Harga --}}
                        <td>
                            <span class="font-weight-bold text-success-600">
                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </span>
                        </td>

                        {{-- 5. Status Badge --}}
                        <td>
                            @if($booking->status == 'active')
                                <span class="badge badge-primary">Sedang Dipinjam</span>
                            @elseif($booking->status == 'pending')
                                <span class="badge badge-warning">Menunggu Konfirmasi</span>
                            @else
                                <span class="badge badge-success">Selesai</span>
                            @endif
                        </td>

                        {{-- 6. Tombol Action Kecil --}}
                        <td class="text-center">
                            <a href="{{ route('bookings.show', $booking->id) }}" class="list-icons-item text-primary-600" data-popup="tooltip" title="Lihat Detail">
                                <i class="icon-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada pesanan masuk hari ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{-- /tabel order terbaru --}}

    @section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
        
            // --- FITUR AUTO REFRESH DASHBOARD ---
            setInterval(function() {
                // 1. Refresh Statistik
                $("#live-stats").load(window.location.href + " #live-stats > *");

                // 2. Refresh Tabel Pesanan
                $("#live-table").load(window.location.href + " #live-table > *", function() {
                    if($('[data-popup="tooltip"]').length) {
                        $('[data-popup="tooltip"]').tooltip();
                    }
                });
                console.log('Dashboard data updated...');
            }, 10000);
        });

        var ctx = document.getElementById('incomeChart').getContext('2d');
        var incomeChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($chart_data),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: '#fff',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ' Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
        
    </script>
    @endsection

@endsection