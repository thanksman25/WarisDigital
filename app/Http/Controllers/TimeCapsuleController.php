<?php

namespace App\Http\Controllers;

use App\Models\TimeCapsule;
use Illuminate\Http\Request;

class TimeCapsuleController extends Controller
{
    // Tampilkan semua kapsul waktu milik user
    public function index()
    {
        $capsules = TimeCapsule::where('user_id', auth()->id())
                               ->orderBy('unlock_at', 'asc')
                               ->get();

        return response()->json($capsules);
    }

    // Buat kapsul waktu baru
    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'message'          => 'nullable|string',
            'document_id'      => 'nullable|exists:documents,id',
            'unlock_at'        => 'required_if:unlock_condition,date|nullable|date|after:now',
            'unlock_condition' => 'required|in:date,death,manual',
        ]);

        $capsule = TimeCapsule::create([
            'user_id'          => auth()->id(),
            'title'            => $request->title,
            'message'          => $request->message,
            'document_id'      => $request->document_id,
            'unlock_at'        => $request->unlock_at,
            'unlock_condition' => $request->unlock_condition,
            'is_unlocked'      => false,
        ]);

        return response()->json([
            'message' => 'Kapsul waktu berhasil dibuat',
            'capsule' => $capsule
        ], 201);
    }

    // Lihat detail kapsul waktu
    public function show($id)
    {
        $capsule = TimeCapsule::where('user_id', auth()->id())
                              ->findOrFail($id);

        // Cek apakah sudah waktunya dibuka
        if (!$capsule->is_unlocked) {
            if ($capsule->unlock_condition === 'date' && now()->greaterThanOrEqualTo($capsule->unlock_at)) {
                $capsule->update(['is_unlocked' => true]);
            } else if ($capsule->unlock_condition !== 'date') {
                return response()->json([
                    'message' => 'Kapsul waktu belum bisa dibuka'
                ], 403);
            } else {
                return response()->json([
                    'message' => 'Kapsul waktu belum waktunya dibuka',
                    'unlock_at' => $capsule->unlock_at
                ], 403);
            }
        }

        return response()->json($capsule);
    }

    // Buka kapsul waktu secara manual (oleh pemilik)
    public function unlock($id)
    {
        $capsule = TimeCapsule::where('user_id', auth()->id())
                              ->findOrFail($id);

        if ($capsule->is_unlocked) {
            return response()->json([
                'message' => 'Kapsul waktu sudah terbuka'
            ]);
        }

        $capsule->update(['is_unlocked' => true]);

        return response()->json([
            'message' => 'Kapsul waktu berhasil dibuka',
            'capsule' => $capsule
        ]);
    }

    // Hapus kapsul waktu
    public function destroy($id)
    {
        $capsule = TimeCapsule::where('user_id', auth()->id())
                              ->findOrFail($id);

        $capsule->delete();

        return response()->json([
            'message' => 'Kapsul waktu berhasil dihapus'
        ]);
    }
}