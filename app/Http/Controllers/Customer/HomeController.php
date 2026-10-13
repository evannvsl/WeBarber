<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Barber;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)->take(6)->get();
        $barbers  = Barber::with('user')->where('is_active', true)->take(4)->get();

        return view('customer.home', compact('services', 'barbers'));
    }

    public function services()
    {
        $services = Service::where('is_active', true)->orderBy('name')->get();

        return view('customer.services', compact('services'));
    }

    public function barbers()
    {
        $barbers = Barber::with('user', 'schedules')
            ->where('is_active', true)
            ->get();

        return view('customer.barbers', compact('barbers'));
    }
}
