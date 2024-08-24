<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\Item;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
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
            $title = 'Aset Tersedia';
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
            $datas = [
                'title' => $title,
                'data' => $data
            ];
        } elseif ($jenis == 'tahunan') {
            $title = 'Inventarisasi Tahunan';
            $tahun = $request->tahun;
            $data = Inventaris::where([
                'tahun_pengadaan' => $tahun,
                ['verified_at', '!=', null],
            ])
                ->withCount('aset', 'inventaris_keluar')
                ->get();
            $datas = [
                'title' => $title,
                'tahun' => $tahun,
                'data' => $data
            ];
        } elseif ($jenis == 'aset_masuk') {
            $title = 'Aset Masuk';
            $tahun = $request->tahun;
            $data = Item::with('inventaris', 'jenis')
                ->whereHas('inventaris', function ($q) use ($tahun) {
                    $q->where('verified_at', '!=', null)
                        ->where('jenis_inventarisasi', 'masuk')
                        ->where('tahun_pengadaan', $tahun);
                })
                ->get();
            $datas = [
                'title' => $title,
                'tahun' => $tahun,
                'data' => $data
            ];
        } elseif ($jenis == 'aset_keluar') {
            $title = 'Aset Keluar';
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
            $datas = [
                'title' => $title,
                'tahun' => $tahun,
                'data' => $data
            ];
        }

        $pdf = PDF::loadView('pages.report.pdf', $datas)->setPaper('A4', 'landscape');
        return $pdf->stream('report_' . $jenis . '-' . strtotime(date('Y-m-d H:i:s')) . '.pdf');
    }
}
