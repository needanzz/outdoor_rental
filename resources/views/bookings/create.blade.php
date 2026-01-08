@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Sewa Barang: <strong>{{ $item->name }}</strong></div>

                <div class="card-body">
                    {{-- Error Validasi --}}
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        
                        {{-- Simpan Harga Satuan di atribut data agar bisa dibaca JS --}}
                        <input type="hidden" id="item_price" value="{{ $item->price }}">

                        <div class="form-group">
                            <label>Harga Sewa per Hari</label>
                            <input type="text" class="form-control" value="Rp {{ number_format($item->price, 0, ',', '.') }}" readonly>
                        </div>

                        <div class="form-group">
                            <label>Jumlah Barang</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" max="{{ $item->stock }}" required>
                            <small class="text-muted">Stok tersedia: {{ $item->stock }}</small>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Selesai</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" required>
                        </div>

                        {{-- INPUT TOTAL HARGA OTOMATIS --}}
                        <div class="form-group bg-light p-3 rounded border">
                            <label class="font-weight-bold">Total Harga:</label>
                            <h3 class="text-success font-weight-bold" id="display_total">Rp 0</h3>
                            <input type="hidden" name="total_price_display" id="total_price_input">
                        </div>

                        <button type="submit" class="btn btn-primary">Ajukan Sewa</button>
                        <a href="{{ route('home') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT HITUNG OTOMATIS --}}
<script>
    $(document).ready(function() {
        // Fungsi Hitung
        function calculateTotal() {
            var pricePerDay = parseInt($('#item_price').val());
            var quantity = parseInt($('#quantity').val());
            var startDate = new Date($('#start_date').val());
            var endDate = new Date($('#end_date').val());

            // Cek apakah tanggal valid & tanggal selesai >= tanggal mulai
            if (startDate && endDate && endDate >= startDate) {
                // Hitung selisih waktu (dalam milidetik)
                var timeDiff = endDate.getTime() - startDate.getTime();
                
                // Ubah ke hari (1 hari = 1000*3600*24 ms)
                // Ditambah 1 karena sewa tanggal 7 s/d 7 dihitung 1 hari
                var daysDiff = (timeDiff / (1000 * 3600 * 24)) + 1;

                if (daysDiff > 0) {
                    var total = pricePerDay * quantity * daysDiff;
                    
                    // Format ke Rupiah
                    var formattedTotal = "Rp " + total.toLocaleString('id-ID');
                    
                    // Tampilkan di layar
                    $('#display_total').text(formattedTotal);
                }
            } else {
                $('#display_total').text("Rp 0");
            }
        }

        // Panggil fungsi setiap kali user ganti input
        $('#start_date, #end_date, #quantity').on('change keyup', function() {
            calculateTotal();
        });
    });
</script>

{{-- NOTIFIKASI EMAIL MASUK --}}
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Booking Berhasil! ⛺',
            html: "Permintaan sewa telah diterima.<br><br><strong>🔔 Silakan Cek Email Anda!</strong><br>Kami telah mengirimkan rincian dan instruksi pembayaran.",
            icon: 'success',
            confirmButtonText: 'Lihat Pesanan Saya',
            confirmButtonColor: '#28a745',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('bookings.mine') }}";
            }
        });
    });
</script>
@endif
@endsection