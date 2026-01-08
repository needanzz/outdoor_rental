<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Item;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\BookingExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingCreatedMail;
use App\Mail\BookingApprovedMail;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Booking::with(['user', 'item'])->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('checkbox', function($row){
                        return '<input type="checkbox" name="booking_checkbox[]" class="booking-checkbox" value="'.$row->id.'">';
                    })
                    ->editColumn('start_date', function($row){
                        return Carbon::parse($row->start_date)->format('d M Y');
                    })
                    ->editColumn('end_date', function($row){
                        return Carbon::parse($row->end_date)->format('d M Y');
                    })
                    ->addColumn('item_price', function($row){
                        return 'Rp ' . number_format($row->item->price, 0, ',', '.');
                    })
                    ->editColumn('total_price', function($row){
                        return 'Rp ' . number_format($row->total_price, 0, ',', '.');
                    })
                    ->addColumn('status', function($row){
                        if ($row->status == 'active') {
                            return '<span class="badge badge-primary">Sedang Dipinjam</span>';
                        } elseif ($row->status == 'pending') {
                            return '<span class="badge badge-warning">Menunggu Konfirmasi</span>';
                        } elseif ($row->status == 'completed') {
                            return '<span class="badge badge-success">Selesai</span>';
                        }
                    })
                    ->addColumn('action', function($row){
                        // Tombol View
                        $btn = '<div class="list-icons">
                                    <a href="'.route('bookings.show', $row->id).'" class="list-icons-item text-primary-600" title="View"><i class="icon-eye"></i></a>';
                        
                        // Tombol Approve / Return
                        if($row->status == 'pending') {
                            $btn .= '<a href="'.route('bookings.approve', $row->id).'" class="list-icons-item text-success-600 ml-2" title="Approve"><i class="icon-checkmark-circle"></i></a>';
                        } elseif ($row->status == 'active') {
                            $btn .= '<a href="'.route('bookings.complete', $row->id).'" class="list-icons-item text-warning-600 ml-2" title="Kembalikan"><i class="icon-spinner11"></i></a>';
                        }

                        // Tombol Delete
                        $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" class="list-icons-item text-danger-600 ml-2 delete-booking" title="Delete"><i class="icon-trash"></i></a>
                                </div>';
                        
                        return $btn;
                    })
                    ->rawColumns(['checkbox','action', 'status'])
                    ->make(true);
        }
        
        return view('bookings.index');
    }

    /**
     * Show the form for creating a new resource.
     *

     */
    public function create($item_id)
    {
        // Cari barang berdasarkan ID yang dikirim dari URL
        $item = Item::findOrFail($item_id);

        // Kirim data barang tersebut ke view
        return view('bookings.create', compact('item'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $item = Item::findOrFail($request->item_id);

        // --- CEK STOK ---
        // Hitung berapa total barang yang sudah dipesan di tanggal tsb
        $booked_qty = Booking::where('item_id', $request->item_id)
            ->whereIn('status', ['pending', 'active'])
            ->where(function ($query) use ($start_date, $end_date) {
                $query->where('start_date', '<=', $end_date->format('Y-m-d'))
                    ->where('end_date', '>=', $start_date->format('Y-m-d'));
            })
            ->sum('quantity');

        // Logika: (Barang dipinjam + Barang yang mau disewa sekarang) > Total Stok Aset
        if (($booked_qty + $request->quantity) > $item->stock) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Stok tidak cukup! Sisa stok di tanggal tsb: ' . ($item->stock - $booked_qty));
        }

        // --- HITUNG HARGA ---
        $days = $start_date->diffInDays($end_date) + 1;
        $total_price = ($days * $item->price) * $request->quantity;

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'item_id' => $request->item_id,
            'quantity' => $request->quantity,
            'start_date' => $start_date->format('Y-m-d'),
            'end_date' => $end_date->format('Y-m-d'),
            'total_price' => $total_price,
            'status' => 'pending',
        ]);

        try {
            Mail::to(auth()->user()->email)->send(new BookingCreatedMail($booking));
        } catch (\Exception $e) {
        }

        return redirect()->back()->with('success', 'Booking berhasil! Total: Rp ' . number_format($total_price));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id

     */
    public function show($id)
    {
        $booking = Booking::with('user', 'item')->findOrFail($id);
        return view('bookings.show', compact('booking'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id

     */
    public function destroy($id)
    {
        $booking = Booking::find($id);

        if ($booking) {
            $booking->delete();
            return response()->json(['success' => 'Data berhasil dihapus!']);
        }

        return response()->json(['error' => 'Data tidak ditemukan!']);
    }

    public function exportExcel()
    {
        return Excel::download(new BookingExport, 'laporan_booking.xlsx');
    }

    public function exportPDF()
    {
        return Excel::download(new BookingExport, 'laporan_booking.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    // Fungsi untuk mengubah status Pending -> Active
    public function approve($id)
    {
        $booking = Booking::with('user')->findOrFail($id);

        if ($booking->status == 'pending') {
            $booking->status = 'active';
            $booking->save();

            // --- KIRIM EMAIL APPROVAL ---
            // Cek apakah user punya email, lalu kirim
            try {
                Mail::to($booking->user->email)->send(new BookingApprovedMail($booking));
            } catch (\Exception $e) {
                \Log::error('Gagal kirim email approve: ' . $e->getMessage());
            }

            return redirect()->back()->with('success', 'Booking disetujui & Email notifikasi dikirim!');
        }

        return redirect()->back()->with('error', 'Status booking tidak valid.');
    }

    // Fungsi untuk mengubah status Active -> Completed (Barang kembali)
    public function complete($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status == 'active') {
            $booking->status = 'completed';
            $booking->save();
            return redirect()->back()->with('success', 'Booking selesai! Barang sudah dikembalikan.');
        }

        return redirect()->back()->with('error', 'Status booking tidak valid.');
    }

    // Fungsi untuk menampilkan riwayat pesanan user yang sedang login
    public function myBookings()
    {
        $bookings = Booking::with('item')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('bookings.my_bookings', compact('bookings'));
    }

    public function bulkDelete(Request $request)
    {
        // Ambil array ID dari ajax
        $ids = $request->ids;
        
        if(!$ids) {
            return response()->json(['error' => 'Tidak ada data yang dipilih'], 400);
        }

        Booking::whereIn('id', $ids)->delete();

        return response()->json(['success' => 'Data terpilih berhasil dihapus!']);
    }
}
