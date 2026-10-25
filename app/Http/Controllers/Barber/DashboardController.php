<?php

namespace App\Http\Controllers\Barber;

use App\Http\Controllers\Controller;
use App\Models\Barber;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private function getBarber()
    {
        $barber = Auth::user()->barber;
        if (! $barber) {
            abort(403, 'Profil barber belum tersedia.');
        }
        return $barber;
    }

    public function index()
    {
        $barber = $this->getBarber();

        $todayBookings = Booking::with(['user', 'details.service'])
            ->where('barber_id', $barber->id)
            ->whereDate('booking_date', today())
            ->whereNotIn('status', ['cancelled'])
            ->orderBy('start_time')
            ->get();

        $stats = [
            'today'     => $todayBookings->count(),
            'pending'   => Booking::where('barber_id', $barber->id)->where('status', 'pending')->count(),
            'completed' => Booking::where('barber_id', $barber->id)->where('status', 'completed')->count(),
            'total'     => Booking::where('barber_id', $barber->id)->count(),
        ];

        return view('barber.dashboard', compact('barber', 'stats', 'todayBookings'));
    }

    public function bookings()
    {
        $barber = $this->getBarber();

        $bookings = Booking::with(['user', 'details.service'])
            ->where('barber_id', $barber->id)
            ->latest()
            ->paginate(15);

        return view('barber.bookings', compact('bookings'));
    }

    public function schedule()
    {
        $barber    = $this->getBarber();
        $schedules = $barber->schedules()->orderBy('day_of_week')->get();

        return view('barber.schedule', compact('barber', 'schedules'));
    }

    public function history()
    {
        $barber = $this->getBarber();

        $history = Booking::with(['user', 'details.service'])
            ->where('barber_id', $barber->id)
            ->where('status', 'completed')
            ->latest()
            ->paginate(15);

        return view('barber.history', compact('history'));
    }
}
