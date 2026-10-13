<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barber;
use App\Models\User;
use Illuminate\Http\Request;

class BarberController extends Controller
{
    public function index()
    {
        $barbers = Barber::with('user')->latest()->paginate(10);
        return view('admin.barbers.index', compact('barbers'));
    }

    public function create()
    {
        // Only users with barber role that don't have a barber profile yet
        $users = User::where('role', 'barber')
            ->whereDoesntHave('barber')
            ->get();

        return view('admin.barbers.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'   => 'required|exists:users,id',
            'specialty' => 'nullable|string|max:100',
            'bio'       => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Barber::create($data);

        return redirect()->route('admin.barbers.index')->with('success', 'Barber berhasil ditambahkan.');
    }

    public function edit(Barber $barber)
    {
        $users = User::where('role', 'barber')->get();
        return view('admin.barbers.edit', compact('barber', 'users'));
    }

    public function update(Request $request, Barber $barber)
    {
        $data = $request->validate([
            'specialty' => 'nullable|string|max:100',
            'bio'       => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $barber->update($data);

        return redirect()->route('admin.barbers.index')->with('success', 'Barber berhasil diperbarui.');
    }

    public function destroy(Barber $barber)
    {
        $barber->delete();
        return back()->with('success', 'Barber berhasil dihapus.');
    }
}
