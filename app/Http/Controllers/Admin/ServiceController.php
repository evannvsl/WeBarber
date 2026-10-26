<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $order   = ['Haircut & Styling', 'Beard & Shave', 'Hair & Scalp Treatment'];
        $grouped = Service::orderBy('name')->get()
            ->groupBy('category')
            ->sortBy(fn($_, $cat) => array_search($cat, $order) !== false ? array_search($cat, $order) : 99);
        return view('admin.services.index', compact('grouped'));
    }

    public function create()
    {
        $categories = Service::CATEGORIES;
        return view('admin.services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:100',
            'category'         => 'required|string|max:50',
            'description'      => 'nullable|string',
            'price'            => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $data['is_active'] = $request->has('is_active');

        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Service $service)
    {
        $categories = Service::CATEGORIES;
        return view('admin.services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:100',
            'category'         => 'required|string|max:50',
            'description'      => 'nullable|string',
            'price'            => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $data['is_active'] = $request->has('is_active');

        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        // Jika service sudah pernah dipakai di booking, nonaktifkan saja (tidak hapus)
        if ($service->bookingDetails()->exists()) {
            $service->update(['is_active' => false]);
            return back()->with('success', 'Layanan dinonaktifkan karena sudah pernah digunakan dalam booking.');
        }

        $service->delete();
        return back()->with('success', 'Layanan berhasil dihapus.');
    }
}
