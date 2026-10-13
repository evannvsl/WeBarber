<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'monthly');

        // Pendapatan harian (30 hari terakhir)
        $dailyRevenue = Payment::where('payment_status', 'paid')
            ->where('paid_at', '>=', now()->subDays(30))
            ->selectRaw("DATE(paid_at) as tanggal, SUM(amount) as total_pendapatan")
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get();

        // Pendapatan bulanan (12 bulan terakhir)
        $monthlyRevenue = Payment::where('payment_status', 'paid')
            ->where('paid_at', '>=', now()->subMonths(12))
            ->selectRaw("DATE_FORMAT(paid_at, '%Y-%m') as bulan, SUM(amount) as total_pendapatan")
            ->groupBy('bulan')
            ->orderBy('bulan', 'desc')
            ->get();

        // Layanan paling populer
        $popularServices = DB::table('booking_details as bd')
            ->join('services as s', 'bd.service_id', '=', 's.id')
            ->join('bookings as b', 'bd.booking_id', '=', 'b.id')
            ->whereIn('b.status', ['confirmed', 'completed'])
            ->selectRaw('s.name as nama_layanan, SUM(bd.quantity) as total_dipesan')
            ->groupBy('s.id', 's.name')
            ->orderByDesc('total_dipesan')
            ->take(10)
            ->get();

        // Barber terbaik
        $topBarbers = DB::table('bookings as b')
            ->join('barbers as br', 'b.barber_id', '=', 'br.id')
            ->join('users as u', 'br.user_id', '=', 'u.id')
            ->whereIn('b.status', ['confirmed', 'completed'])
            ->selectRaw('u.name, COUNT(b.id) as total_pelayanan')
            ->groupBy('br.id', 'u.name')
            ->orderByDesc('total_pelayanan')
            ->take(5)
            ->get();

        return view('admin.reports.index', compact(
            'dailyRevenue',
            'monthlyRevenue',
            'popularServices',
            'topBarbers'
        ));
    }
}
