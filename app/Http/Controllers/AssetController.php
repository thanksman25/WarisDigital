<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    // Tampilkan semua aset milik user
    public function index()
    {
        $assets = Asset::where('user_id', auth()->id())
                       ->where('is_active', true)
                       ->get();

        return \Inertia\Inertia::render('Assets/Index', ['assets' => $assets]);
    }

    // Tambah aset baru
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:tanah,rumah,kendaraan,tabungan,investasi,lainnya',
            'description' => 'nullable|string',
            'value'       => 'nullable|numeric|min:0',
            'location'    => 'nullable|string',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'document_id' => 'nullable|exists:documents,id',
        ]);

        Asset::create([
            'user_id'     => auth()->id(),
            'name'        => $request->name,
            'type'        => $request->type,
            'description' => $request->description,
            'value'       => $request->value,
            'location'    => $request->location,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
            'document_id' => $request->document_id,
            'is_active'   => true,
        ]);

        return redirect()->route('assets.index')->with('success', 'Aset berhasil ditambahkan.');
    }

    // Lihat detail aset
    public function show($id)
    {
        $asset = Asset::where('user_id', auth()->id())
                      ->findOrFail($id);

        return response()->json($asset);
    }

    // Update aset
    public function update(Request $request, $id)
    {
        $asset = Asset::where('user_id', auth()->id())
                      ->findOrFail($id);

        $request->validate([
            'name'        => 'sometimes|string|max:255',
            'type'        => 'sometimes|in:tanah,rumah,kendaraan,tabungan,investasi,lainnya',
            'description' => 'nullable|string',
            'value'       => 'nullable|numeric|min:0',
            'location'    => 'nullable|string',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'document_id' => 'nullable|exists:documents,id',
        ]);

        $asset->update($request->all());

        return response()->json([
            'message' => 'Aset berhasil diupdate',
            'asset'   => $asset
        ]);
    }

    // Hapus aset (soft delete)
    public function destroy($id)
    {
        $asset = Asset::where('user_id', auth()->id())
                      ->findOrFail($id);

        $asset->update(['is_active' => false]);

        return redirect()->route('assets.index')->with('success', 'Aset berhasil dihapus.');
    }

    // Ringkasan total nilai aset
    public function summary()
    {
        $assets = Asset::where('user_id', auth()->id())
                       ->where('is_active', true)
                       ->get();

        $summary = $assets->groupBy('type')->map(function ($group) {
            return [
                'total_items' => $group->count(),
                'total_value' => $group->sum('value'),
            ];
        });

        return response()->json([
            'total_assets' => $assets->count(),
            'total_value'  => $assets->sum('value'),
            'by_type'      => $summary,
        ]);
    }
}