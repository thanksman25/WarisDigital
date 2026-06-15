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
        return \Inertia\Inertia::render('Documents/Index', ['documents' => $documents]);
    }

    // Upload dokumen baru
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'file'        => 'required|file|max:10240', // max 10MB
            'file_type'   => 'nullable|string',
        ]);

        $file     = $request->file('file');
        $path     = $file->store('vault/' . auth()->id(), 'private');

        Document::create([
            'user_id'      => auth()->id(),
            'title'        => $request->title,
            'description'  => $request->description,
            'file_path'    => $path,
            'file_type'    => $request->file_type ?? 'Lainnya',
            'file_size'    => $file->getSize(),
            'is_encrypted' => false,
        ]);

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diunggah.');
    }

    // Lihat detail dokumen
    public function show($id = null)
    {
        $docId = $id ?? request('id');
        $document = Document::where('user_id', auth()->id())
                            ->findOrFail($docId);

        $reminder = \App\Models\Reminder::where('document_id', $document->id)->first();

        return \Inertia\Inertia::render('Documents/Show', [
            'document' => $document,
            'reminder' => $reminder,
        ]);
    }

    // Hapus dokumen
    public function destroy($id)
    {
        $document = Document::where('user_id', auth()->id())
                            ->findOrFail($id);

        if ($document->file_path !== 'dummy') {
            Storage::disk('private')->delete($document->file_path);
        }
        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}