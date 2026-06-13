<?php

namespace App\Http\Controllers;

use App\Models\AccessPermission;
use App\Models\Document;
use Illuminate\Http\Request;

class AccessPermissionController extends Controller
{
    // Beri akses ke user lain
    public function store(Request $request)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'user_id'     => 'required|exists:users,id',
            'permission'  => 'required|in:view,download,edit',
        ]);

        // Cek apakah dokumen milik user yang login
        $document = Document::where('id', $request->document_id)
                            ->where('user_id', auth()->id())
                            ->firstOrFail();

        // Cek apakah sudah ada permission sebelumnya
        $existing = AccessPermission::where('document_id', $request->document_id)
                                    ->where('user_id', $request->user_id)
                                    ->first();

        if ($existing) {
            $existing->update(['permission' => $request->permission]);
            return response()->json([
                'message'    => 'Akses berhasil diperbarui',
                'permission' => $existing
            ]);
        }

        $permission = AccessPermission::create([
            'document_id' => $request->document_id,
            'user_id'     => $request->user_id,
            'permission'  => $request->permission,
        ]);

        return response()->json([
            'message'    => 'Akses berhasil diberikan',
            'permission' => $permission
        ], 201);
    }

    // Lihat siapa saja yang punya akses ke dokumen
    public function index($document_id)
    {
        $document = Document::where('id', $document_id)
                            ->where('user_id', auth()->id())
                            ->firstOrFail();

        $permissions = AccessPermission::where('document_id', $document_id)
                                        ->with('user')
                                        ->get();

        return response()->json($permissions);
    }

    // Cabut akses user dari dokumen
    public function destroy($id)
    {
        $permission = AccessPermission::findOrFail($id);

        // Pastikan hanya pemilik dokumen yang bisa cabut akses
        $document = Document::where('id', $permission->document_id)
                            ->where('user_id', auth()->id())
                            ->firstOrFail();

        $permission->delete();

        return response()->json([
            'message' => 'Akses berhasil dicabut'
        ]);
    }
}