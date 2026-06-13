<?php

namespace App\Http\Controllers;

use App\Models\ClaimGuide;
use Illuminate\Http\Request;

class ClaimGuideController extends Controller
{
    // Tampilkan semua panduan klaim
    public function index()
    {
        $guides = ClaimGuide::where('is_active', true)->get();
        return response()->json($guides);
    }

    // Tampilkan panduan berdasarkan institusi
    public function byInstitution($institution)
    {
        $guides = ClaimGuide::where('institution', $institution)
                            ->where('is_active', true)
                            ->get();

        return response()->json($guides);
    }

    // Lihat detail panduan
    public function show($id)
    {
        $guide = ClaimGuide::where('is_active', true)
                           ->findOrFail($id);

        return response()->json($guide);
    }

    // Tambah panduan baru (admin)
    public function store(Request $request)
    {
        $request->validate([
            'institution'        => 'required|string|max:255',
            'title'              => 'required|string|max:255',
            'description'        => 'nullable|string',
            'steps'              => 'required|array',
            'steps.*'            => 'string',
            'documents_required' => 'nullable|array',
            'documents_required.*' => 'string',
            'estimated_time'     => 'nullable|string',
        ]);

        $guide = ClaimGuide::create([
            'institution'        => $request->institution,
            'title'              => $request->title,
            'description'        => $request->description,
            'steps'              => $request->steps,
            'documents_required' => $request->documents_required,
            'estimated_time'     => $request->estimated_time,
            'is_active'          => true,
        ]);

        return response()->json([
            'message' => 'Panduan klaim berhasil ditambahkan',
            'guide'   => $guide
        ], 201);
    }

    // Update panduan (admin)
    public function update(Request $request, $id)
    {
        $guide = ClaimGuide::findOrFail($id);

        $request->validate([
            'institution'        => 'sometimes|string|max:255',
            'title'              => 'sometimes|string|max:255',
            'description'        => 'nullable|string',
            'steps'              => 'sometimes|array',
            'documents_required' => 'nullable|array',
            'estimated_time'     => 'nullable|string',
            'is_active'          => 'sometimes|boolean',
        ]);

        $guide->update($request->all());

        return response()->json([
            'message' => 'Panduan klaim berhasil diupdate',
            'guide'   => $guide
        ]);
    }

    // Hapus panduan (admin)
    public function destroy($id)
    {
        $guide = ClaimGuide::findOrFail($id);
        $guide->delete();

        return response()->json([
            'message' => 'Panduan klaim berhasil dihapus'
        ]);
    }
}