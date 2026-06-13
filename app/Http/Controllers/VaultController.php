<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VaultController extends Controller
{
    // Tampilkan semua dokumen milik user yang login
    public function index()
    {
        $documents = Document::where('user_id', auth()->id())->get();
        return response()->json($documents);
    }

    // Upload dokumen baru
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'file'        => 'required|file|max:10240', // max 10MB
        ]);

        $file     = $request->file('file');
        $path     = $file->store('vault/' . auth()->id(), 'private');

        $document = Document::create([
            'user_id'      => auth()->id(),
            'title'        => $request->title,
            'description'  => $request->description,
            'file_path'    => $path,
            'file_type'    => $file->getClientMimeType(),
            'file_size'    => $file->getSize(),
            'is_encrypted' => false,
        ]);

        return response()->json([
            'message'  => 'Dokumen berhasil diupload',
            'document' => $document
        ], 201);
    }

    // Lihat detail dokumen
    public function show($id)
    {
        $document = Document::where('user_id', auth()->id())
                            ->findOrFail($id);

        return response()->json($document);
    }

    // Hapus dokumen
    public function destroy($id)
    {
        $document = Document::where('user_id', auth()->id())
                            ->findOrFail($id);

        Storage::disk('private')->delete($document->file_path);
        $document->delete();

        return response()->json([
            'message' => 'Dokumen berhasil dihapus'
        ]);
    }
}