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
            return redirect()->route('access.index')->with('success', 'Akses berhasil diperbarui.');
        }

        AccessPermission::create([
            'document_id' => $request->document_id,
            'user_id'     => $request->user_id,
            'permission'  => $request->permission,
        ]);

        return redirect()->route('access.index')->with('success', 'Akses berhasil diberikan.');
    }

    public function index($document_id = null)
    {
        if ($document_id) {
            $permissions = AccessPermission::where('document_id', $document_id)
                                           ->with(['user', 'document'])
                                           ->get();
        } else {
            $permissions = AccessPermission::whereHas('document', function ($query) {
                $query->where('user_id', auth()->id());
            })->with(['user', 'document'])->get();
        }

        return \Inertia\Inertia::render('Access/Index', ['permissions' => $permissions]);
    }

    // Cabut akses user dari dokumen
    public function create()
    {
        $documents = Document::where('user_id', auth()->id())->get();
        $users = \App\Models\User::where('id', '!=', auth()->id())->get();

        return \Inertia\Inertia::render('Access/Create', [
            'documents' => $documents,
            'users'     => $users,
        ]);
    }

    public function destroy($id)
    {
        $permission = AccessPermission::findOrFail($id);

        // Pastikan hanya pemilik dokumen yang bisa cabut akses
        $document = Document::where('id', $permission->document_id)
                            ->where('user_id', auth()->id())
                            ->firstOrFail();

        $permission->delete();

        return redirect()->route('access.index')->with('success', 'Akses berhasil dicabut.');
    }
}