<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barber;
use App\Models\BarberSchedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $barbers = Barber::with('user', 'schedules')->get();
        return view('admin.schedules.index', compact('barbers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'barber_id'   => 'required|exists:barbers,id',
            'day_of_week' => 'required|integer|between:1,7',
            'start_time'  => 'required_if:is_day_off,false',
            'end_time'    => 'required_if:is_day_off,false',
            'is_day_off'  => 'boolean',
        ]);

        $data['is_day_off'] = $request->has('is_day_off');

        BarberSchedule::updateOrCreate(
            ['barber_id' => $data['barber_id'], 'day_of_week' => $data['day_of_week']],
            $data
        );

        return back()->with('success', 'Jadwal berhasil disimpan.');
    }

    public function destroy(BarberSchedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Jadwal berhasil dihapus.');
    }
}
