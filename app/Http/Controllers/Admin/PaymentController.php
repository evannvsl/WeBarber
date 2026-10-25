<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('booking.user')
            ->latest()
            ->paginate(15);

        $stats = [
            'total'    => Payment::count(),
            'paid'     => Payment::where('payment_status', 'paid')->count(),
            'pending'  => Payment::where('payment_status', 'pending')->count(),
            'revenue'  => Payment::where('payment_status', 'paid')->sum('amount'),
        ];

        return view('admin.payments.index', compact('payments', 'stats'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'booking_id'     => 'required|exists:bookings,id',
            'amount'         => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,transfer,qris',
        ]);

        $payment = Payment::create([
            ...$data,
            'payment_status' => 'paid',
            'paid_at'        => now(),
        ]);

        // Update booking status to completed
        $payment->booking->update(['status' => 'completed']);

        return back()->with('success', 'Pembayaran berhasil dicatat.');
    }

    public function update(Request $request, Payment $payment)
    {
        $data = $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        if ($data['payment_status'] === 'paid') {
            $data['paid_at'] = now();
        }

        $payment->update($data);

        return back()->with('success', 'Status pembayaran diperbarui.');
    }
}
