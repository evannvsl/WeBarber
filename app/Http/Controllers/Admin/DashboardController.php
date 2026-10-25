<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barber;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_customers' => User::where('role', 'customer')->count(),
            'total_barbers'   => Barber::where('is_active', true)->count(),
            'total_bookings'  => Booking::count(),
            'total_revenue'   => Payment::where('payment_status', 'paid')->sum('amount'),
        ];

        $recentBookings = Booking::with('user', 'barber.user')
            ->latest()
            ->take(5)
            ->get();

        // Pendapatan bulanan (6 bulan terakhir)
        $monthlyRevenue = Payment::where('payment_status', 'paid')
            ->where('paid_at', '>=', now()->subMonths(6))
            ->selectRaw("DATE_FORMAT(paid_at, '%Y-%m') as month, SUM(amount) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Layanan paling populer
        $popularServices = DB::table('booking_details as bd')
            ->join('services as s', 'bd.service_id', '=', 's.id')
            ->join('bookings as b', 'bd.booking_id', '=', 'b.id')
            ->whereIn('b.status', ['confirmed', 'completed'])
            ->selectRaw('s.name as nama_layanan, SUM(bd.quantity) as total_dipesan')
            ->groupBy('s.id', 's.name')
            ->orderByDesc('total_dipesan')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'monthlyRevenue', 'popularServices'));
    }
}
