<!DOCTYPE html>
<html>
<head>
    <title>Konfirmasi Booking</title>
</head>
<body>
    <h1>Halo, {{ $booking->user->name }}! 👋</h1>
    
    <p>Terima kasih telah melakukan penyewaan di Rental Outdoor kami.</p>
    <p>Berikut adalah detail pesanan Anda:</p>
    
    <div style="background-color: #f3f3f3; padding: 20px; border-radius: 5px;">
        <p><strong>Barang:</strong> {{ $booking->item->name }}</p>
        <p><strong>Harga /hari:</strong> Rp {{ number_format($booking->item->price) }}</p>
        <p><strong>Tanggal Mulai:</strong> {{ $booking->start_date }}</p>
        <p><strong>Tanggal Selesai:</strong> {{ $booking->end_date }}</p>
        <p><strong>Total Harga:</strong> Rp {{ number_format($booking->total_price) }}</p>
        <p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
    </div>

    <p>Silakan lakukan pembayaran melalui nomor rekening berikut: <strong>1234567890</strong> (Bank BRI) agar pesanan segera diproses.</p>
    
    <p>Salam,<br>
    Admin Outdoor Rental</p>
</body>
</html>