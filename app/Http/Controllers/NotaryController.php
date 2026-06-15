<?php

namespace App\Http\Controllers;

use App\Models\Notary;
use Illuminate\Http\Request;

class NotaryController extends Controller
{
    // Tampilkan semua notaris terverifikasi
    public function index()
    {
        $notaries = Notary::where('is_verified', true)
                          ->orderBy('rating', 'desc')
                          ->get();

        return \Inertia\Inertia::render('Notary/Index', ['notaries' => $notaries]);
    }

    // Cari notaris berdasarkan kota/provinsi
    public function search(Request $request)
    {
        $query = Notary::where('is_verified', true);

        if ($request->has('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->has('province')) {
            $query->where('province', 'like', '%' . $request->province . '%');
        }

        if ($request->has('specialization')) {
            $query->where('specialization', 'like', '%' . $request->specialization . '%');
        }

        $notaries = $query->orderBy('rating', 'desc')->get();

        return response()->json($notaries);
    }

    // Lihat detail notaris
    public function show($id)
    {
        $notary = Notary::where('is_verified', true)
                        ->findOrFail($id);

        return response()->json($notary);
    }

    // Tambah notaris baru (admin)
    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:notaries,email',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string',
            'city'           => 'required|string|max:100',
            'province'       => 'required|string|max:100',
            'license_number' => 'required|string|unique:notaries,license_number',
            'specialization' => 'nullable|string|max:255',
        ]);

        $notary = Notary::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'address'        => $request->address,
            'city'           => $request->city,
            'province'       => $request->province,
            'license_number' => $request->license_number,
            'specialization' => $request->specialization,
            'is_verified'    => false,
            'rating'         => 0,
        ]);

        return response()->json([
            'message' => 'Notaris berhasil didaftarkan',
            'notary'  => $notary
        ], 201);
    }

    // Update data notaris (admin)
    public function update(Request $request, $id)
    {
        $notary = Notary::findOrFail($id);

        $request->validate([
            'name'           => 'sometimes|string|max:255',
            'email'          => 'sometimes|email|unique:notaries,email,' . $id,
            'phone'          => 'sometimes|string|max:20',
            'address'        => 'sometimes|string',
            'city'           => 'sometimes|string|max:100',
            'province'       => 'sometimes|string|max:100',
            'license_number' => 'sometimes|string|unique:notaries,license_number,' . $id,
            'specialization' => 'nullable|string|max:255',
            'is_verified'    => 'sometimes|boolean',
            'rating'         => 'sometimes|numeric|min:0|max:5',
        ]);

        $notary->update($request->all());

        return response()->json([
            'message' => 'Data notaris berhasil diupdate',
            'notary'  => $notary
        ]);
    }

    // Hapus notaris (admin)
    public function destroy($id)
    {
        $notary = Notary::findOrFail($id);
        $notary->delete();

        return response()->json([
            'message' => 'Notaris berhasil dihapus'
        ]);
    }
}