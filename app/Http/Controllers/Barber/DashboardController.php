<?php

namespace App\Http\Controllers\Barber;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $barber = Auth::user()->barber;

        if (! $barber) {
            abort(403, 'Profil barber belum tersedia.');
        }

        $stats = [
            'today_bookings'  => Booking::where('barber_id', $barber->id)
                ->whereDate('booking_date', today())
                ->whereNotIn('status', ['cancelled'])
                ->count(),
            'total_completed' => Booking::where('barber_id', $barber->id)
                ->where('status', 'completed')
                ->count(),
            'pending_count'   => Booking::where('barber_id', $barber->id)
                ->where('status', 'pending')
                ->count(),
        ];

        $todayBookings = Booking::with('user', 'details.service')
            ->where('barber_id', $barber->id)
            ->whereDate('booking_date', today())
            ->whereNotIn('status', ['cancelled'])
            ->orderBy('start_time')
            ->get();

        return view('barber.dashboard', compact('barber', 'stats', 'todayBookings'));
    }

    public function bookings()
    {
        $barber = Auth::user()->barber;

        $bookings = Booking::with('user', 'details.service')
            ->where('barber_id', $barber->id)
            ->latest()
            ->paginate(15);

        return view('barber.bookings', compact('bookings'));
    }

    public function schedule()
    {
        $barber    = Auth::user()->barber;
        $schedules = $barber->schedules()->orderBy('day_of_week')->get();

        return view('barber.schedule', compact('barber', 'schedules'));
    }

    public function history()
    {
        $barber = Auth::user()->barber;

        $history = Booking::with('user', 'details.service')
            ->where('barber_id', $barber->id)
            ->where('status', 'completed')
            ->latest()
            ->paginate(15);

        return view('barber.history', compact('history'));
    }
}
