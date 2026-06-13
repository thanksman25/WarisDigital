<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    // Tampilkan semua reminder milik user
    public function index()
    {
        $reminders = Reminder::where('user_id', auth()->id())
                             ->orderBy('remind_at', 'asc')
                             ->get();

        return response()->json($reminders);
    }

    // Buat reminder baru
    public function store(Request $request)
    {
        $request->validate([
            'document_id' => 'nullable|exists:documents,id',
            'title'       => 'required|string|max:255',
            'message'     => 'nullable|string',
            'remind_at'   => 'required|date|after:now',
        ]);

        $reminder = Reminder::create([
            'user_id'     => auth()->id(),
            'document_id' => $request->document_id,
            'title'       => $request->title,
            'message'     => $request->message,
            'remind_at'   => $request->remind_at,
            'is_sent'     => false,
        ]);

        return response()->json([
            'message'  => 'Reminder berhasil dibuat',
            'reminder' => $reminder
        ], 201);
    }

    // Lihat detail reminder
    public function show($id)
    {
        $reminder = Reminder::where('user_id', auth()->id())
                            ->findOrFail($id);

        return response()->json($reminder);
    }

    // Update reminder
    public function update(Request $request, $id)
    {
        $reminder = Reminder::where('user_id', auth()->id())
                            ->findOrFail($id);

        $request->validate([
            'title'     => 'sometimes|string|max:255',
            'message'   => 'nullable|string',
            'remind_at' => 'sometimes|date|after:now',
        ]);

        $reminder->update($request->only(['title', 'message', 'remind_at']));

        return response()->json([
            'message'  => 'Reminder berhasil diupdate',
            'reminder' => $reminder
        ]);
    }

    // Hapus reminder
    public function destroy($id)
    {
        $reminder = Reminder::where('user_id', auth()->id())
                            ->findOrFail($id);

        $reminder->delete();

        return response()->json([
            'message' => 'Reminder berhasil dihapus'
        ]);
    }
}