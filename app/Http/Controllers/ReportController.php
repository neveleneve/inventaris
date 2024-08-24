<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\Item;
use Illuminate\Http\Request;

class ReportController extends Controller {
    public function __construct() {
        $this->middleware('permission:report index')->only('index');
    }

    public function index() {
        return view('pages.report.index');
    }

    public function cetak(Request $request, $jenis) {
        if ($jenis == 'aset_tersedia') {
            $data = Item::with('inventaris', 'jenis')
                ->whereHas('inventaris', function ($q) {
                    $q->where('verified_at', '!=', null)
                        ->where('jenis_inventarisasi', 'masuk');
                })
                ->whereDoesntHave('inventaris_keluar', function ($q) {
                    $q->whereHas('inventaris', function ($subQuery) {
                        $subQuery->where('jenis_inventarisasi', 'keluar')
                            ->where('verified_at', '!=', null);
                    });
                })
                ->get();
        } elseif ($jenis == 'tahunan') {
            $data = Inventaris::where([
                'tahun_pengadaan' => $request->tahun,
                ['verified_at', '!=', null],
            ])->get();
        } elseif ($jenis == 'aset_masuk') {
            $tahun = $request->tahun;
            $data = Item::with('inventaris', 'jenis')
                ->whereHas('inventaris', function ($q) use ($tahun) {
                    $q->where('verified_at', '!=', null)
                        ->where('jenis_inventarisasi', 'masuk')
                        ->where('tahun_pengadaan', $tahun);
                })
                ->get();
        } elseif ($jenis == 'aset_keluar') {
            $tahun = $request->tahun;
            $data = Item::with('inventaris_keluar', 'jenis')
                ->whereHas('inventaris_keluar', function ($q) use ($tahun) {
                    $q->whereHas('inventaris', function ($subQuery) use ($tahun) {
                        $subQuery->where('jenis_inventarisasi', 'keluar')
                            ->where('verified_at', '!=', null)
                            ->where('tahun_pengadaan', $tahun);
                    });
                })
                ->get();
        }
        dd($data);
    }
}
