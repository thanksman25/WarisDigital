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

        return \Inertia\Inertia::render('TimeCapsule/Index', ['capsules' => $capsules]);
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

        TimeCapsule::create([
            'user_id'          => auth()->id(),
            'title'            => $request->title,
            'message'          => $request->message,
            'document_id'      => $request->document_id,
            'unlock_at'        => $request->unlock_at,
            'unlock_condition' => $request->unlock_condition,
            'is_unlocked'      => false,
        ]);

        return redirect()->route('time-capsule.index')->with('success', 'Kapsul waktu berhasil dibuat.');
    }

    // Lihat detail kapsul waktu
    public function show($id)
    {
        $capsule = TimeCapsule::where('user_id', auth()->id())
                              ->with('document')
                              ->findOrFail($id);

        // Cek apakah sudah waktunya dibuka
        if (!$capsule->is_unlocked) {
            if ($capsule->unlock_condition === 'date' && now()->greaterThanOrEqualTo($capsule->unlock_at)) {
                $capsule->update(['is_unlocked' => true]);
            }
        }

        return \Inertia\Inertia::render('TimeCapsule/Show', [
            'capsule' => $capsule,
        ]);
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

        return redirect()->route('time-capsule.index')->with('success', 'Kapsul waktu berhasil dihapus.');
    }
}