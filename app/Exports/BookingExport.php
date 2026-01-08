<?php

namespace App\Exports;

use App\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BookingExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Kita ambil data lengkap dengan relasinya agar tidak berat (N+1 problem)
        return Booking::with(['user', 'item'])->get();
    }

    // Menentukan Judul Kolom di Excel (Baris pertama)
    public function headings(): array
    {
        return [
            'ID Booking',
            'Nama Penyewa',
            'Nama Barang',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Total Harga',
            'Status',
        ];
    }

    // Mengatur data apa saja yang masuk ke kolom-kolom di atas
    public function map($booking): array
    {
        return [
            $booking->id,
            $booking->user->name, // Mengubah User ID jadi Nama
            $booking->item->name, // Mengubah Item ID jadi Nama Barang
            $booking->start_date,
            $booking->end_date,
            'Rp' . number_format($booking->total_price, 0, ',', '.'),
            $booking->status,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],
        ];
    }
}