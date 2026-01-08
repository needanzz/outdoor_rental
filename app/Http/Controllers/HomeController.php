<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Item;
use App\Booking;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // 1. JIKA ADMIN: Tampilkan Dashboard Statistik
        if (auth()->check() && auth()->user()->role == 'admin') {
            $total_users = User::count();
            $total_items = Item::count();
            $total_bookings = Booking::count();
            $total_income = Booking::whereIn('status', ['active', 'completed'])->sum('total_price');
            $recent_bookings = Booking::with(['user', 'item'])->latest()->take(5)->get();

            $monthly_income = Booking::selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
                ->whereIn('status', ['active', 'completed'])
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->pluck('total', 'month')
                ->toArray();

            $chart_data = [];
            for ($i = 1; $i <= 12; $i++) {
                // Jika bulan ada datanya, pakai datanya. Jika tidak, 0.
                $chart_data[] = isset($monthly_income[$i]) ? $monthly_income[$i] : 0;
            }

            return view('home', compact('total_users', 'total_items', 'total_bookings', 'total_income', 'recent_bookings', 'chart_data'));
        }

        // 2. JIKA USER BIASA: Tampilkan Katalog Barang
        $items = Item::all();
        return view('catalogs.index', compact('items'));
    }
}