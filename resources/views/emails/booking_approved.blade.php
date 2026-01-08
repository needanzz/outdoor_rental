<!DOCTYPE html>
<html>
<head>
    <title>Booking Disetujui</title>
</head>
<body>
    <h1>Pembayaran Dikonfirmasi! ✅</h1>
    <p>Halo, {{ $booking->user->name }}.</p>
    
    <p>Terima kasih sudah melakukan pembayaran. Status pesanan Anda sekarang adalah <strong>ACTIVE</strong>.</p>
    
    <div style="background-color: #d4edda; padding: 20px; border-radius: 5px; color: #155724;">
        <h3>Silakan Ambil Barang Anda!</h3>
        <p><strong>Barang:</strong> {{ $booking->item->name }}</p>
        <p><strong>Tanggal Ambil:</strong> {{ $booking->start_date }}</p>
        <p><strong>Total Sudah Dibayar:</strong> Rp {{ number_format($booking->total_price) }}</p>
    </div>

    <p><strong>Catatan Penting:</strong></p>
    <ul>
        <li>Harap membawa KTP/Identitas saat pengambilan barang.</li>
        <li>Tunjukkan email ini kepada petugas kami.</li>
    </ul>
    
    <p>Selamat berpetualang!<br>
    Admin Outdoor Rental</p>
</body>
</html>