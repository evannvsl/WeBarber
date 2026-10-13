<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Barber;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function create()
    {
        $services = Service::where('is_active', true)->get();
        $barbers  = Barber::with('user', 'schedules')->where('is_active', true)->get();

        return view('customer.booking', compact('services', 'barbers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'barber_id'    => 'required|exists:barbers,id',
            'service_ids'  => 'required|array|min:1',
            'service_ids.*' => 'exists:services,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time'   => 'required',
            'notes'        => 'nullable|string|max:500',
        ]);

        // Calculate total duration and end time
        $services  = Service::whereIn('id', $data['service_ids'])->get();
        $totalMins = $services->sum('duration_minutes');
        $start     = \Carbon\Carbon::parse($data['booking_date'] . ' ' . $data['start_time']);
        $end       = $start->copy()->addMinutes($totalMins);

        // Check for conflicting bookings
        $conflict = Booking::where('barber_id', $data['barber_id'])
            ->where('booking_date', $data['booking_date'])
            ->whereNotIn('status', ['cancelled'])
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_time', [$start->format('H:i'), $end->format('H:i')])
                  ->orWhereBetween('end_time', [$start->format('H:i'), $end->format('H:i')])
                  ->orWhere(function ($q2) use ($start, $end) {
                      $q2->where('start_time', '<=', $start->format('H:i'))
                         ->where('end_time', '>=', $end->format('H:i'));
                  });
            })->exists();

        if ($conflict) {
            return back()->withErrors(['start_time' => 'Barber sudah ada jadwal di waktu tersebut.'])->withInput();
        }

        DB::transaction(function () use ($data, $services, $start, $end) {
            $booking = Booking::create([
                'user_id'      => Auth::id(),
                'barber_id'    => $data['barber_id'],
                'booking_date' => $data['booking_date'],
                'start_time'   => $start->format('H:i'),
                'end_time'     => $end->format('H:i'),
                'status'       => 'pending',
                'notes'        => $data['notes'] ?? null,
            ]);

            foreach ($services as $service) {
                BookingDetail::create([
                    'booking_id' => $booking->id,
                    'service_id' => $service->id,
                    'quantity'   => 1,
                    'price'      => $service->price,
                ]);
            }
        });

        return redirect()->route('customer.history')->with('success', 'Booking berhasil dibuat!');
    }

    public function history()
    {
        $bookings = Booking::with('barber.user', 'details.service', 'payments')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('customer.history', compact('bookings'));
    }

    public function cancel(Booking $booking)
    {
        abort_unless($booking->user_id === Auth::id(), 403);
        abort_unless($booking->status === 'pending', 422, 'Hanya booking pending yang bisa dibatalkan.');

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking berhasil dibatalkan.');
    }
}
