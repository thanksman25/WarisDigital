<?php

namespace App\Http\Controllers;

use App\Models\Inheritance;
use Illuminate\Http\Request;

class InheritanceController extends Controller
{
    // Tampilkan semua simulasi milik user
    public function index()
    {
        $simulations = Inheritance::where('user_id', auth()->id())
                                  ->orderBy('created_at', 'desc')
                                  ->get();

        return \Inertia\Inertia::render('Inheritance/Index', ['simulations' => $simulations]);
    }

    // Buat simulasi waris baru
    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'total_assets' => 'required|numeric|min:0',
            'law_type'     => 'required|in:islam,perdata,adat',
            'heirs'        => 'required|array',
            'heirs.*.name' => 'required|string',
            'heirs.*.relation' => 'required|string', // suami, istri, anak_laki, anak_perempuan, ayah, ibu, dll
        ]);

        $result = $this->calculate(
            $request->total_assets,
            $request->law_type,
            $request->heirs
        );

        Inheritance::create([
            'user_id'      => auth()->id(),
            'title'        => $request->title,
            'total_assets' => $request->total_assets,
            'law_type'     => $request->law_type,
            'heirs'        => $request->heirs,
            'result'       => $result,
        ]);

        return redirect()->route('inheritance.index')->with('success', 'Simulasi waris berhasil disimpan.');
    }

    // Lihat detail simulasi
    public function show($id)
    {
        $simulation = Inheritance::where('user_id', auth()->id())
                                 ->findOrFail($id);

        return response()->json($simulation);
    }

    // Hapus simulasi
    public function destroy($id)
    {
        $simulation = Inheritance::where('user_id', auth()->id())
                                 ->findOrFail($id);

        $simulation->delete();

        return redirect()->route('inheritance.index')->with('success', 'Simulasi waris berhasil dihapus.');
    }

    // Logika perhitungan waris
    private function calculate($totalAssets, $lawType, $heirs)
    {
        if ($lawType === 'islam') {
            return $this->calculateIslam($totalAssets, $heirs);
        } elseif ($lawType === 'perdata') {
            return $this->calculatePerdata($totalAssets, $heirs);
        } else {
            return $this->calculateAdat($totalAssets, $heirs);
        }
    }

    // Perhitungan waris Islam
    private function calculateIslam($totalAssets, $heirs)
    {
        $result = [];
        $shares = [
            'suami'           => 1/4,  // jika ada anak
            'istri'           => 1/8,  // jika ada anak
            'anak_laki'       => 2,    // 2x bagian anak perempuan
            'anak_perempuan'  => 1,
            'ayah'            => 1/6,
            'ibu'             => 1/6,
        ];

        $totalShare = 0;
        foreach ($heirs as $heir) {
            $relation = $heir['relation'];
            $share    = $shares[$relation] ?? 0;
            $totalShare += $share;
        }

        foreach ($heirs as $heir) {
            $relation = $heir['relation'];
            $share    = $shares[$relation] ?? 0;
            $portion  = $totalShare > 0 ? ($share / $totalShare) * $totalAssets : 0;

            $result[] = [
                'name'     => $heir['name'],
                'relation' => $relation,
                'share'    => $share,
                'amount'   => round($portion, 2),
            ];
        }

        return $result;
    }

    // Perhitungan waris Perdata
    private function calculatePerdata($totalAssets, $heirs)
    {
        $result  = [];
        $count   = count($heirs);
        $portion = $count > 0 ? $totalAssets / $count : 0;

        foreach ($heirs as $heir) {
            $result[] = [
                'name'     => $heir['name'],
                'relation' => $heir['relation'],
                'amount'   => round($portion, 2),
            ];
        }

        return $result;
    }

    // Perhitungan waris Adat (dibagi rata)
    private function calculateAdat($totalAssets, $heirs)
    {
        return $this->calculatePerdata($totalAssets, $heirs);
    }
}