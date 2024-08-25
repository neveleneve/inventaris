<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\InventarisKeluar;
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

    public function inventaris(Request $request) {
        if (isset($request->id)) {
            $inventaris = Inventaris::find($request->id);
            if ($inventaris) {
                if ($inventaris->verified_at && $inventaris->kode_inventarisasi == $request->kode) {
                    $data = [];
                    if ($inventaris->jenis_inventarisasi == 'masuk') {
                        $data['inventaris'] = [
                            'id' => $inventaris->id,
                            'kode' => $inventaris->kode_inventarisasi,
                            'jenis' => $inventaris->jenis_inventarisasi,
                            'tahun' => $inventaris->tahun_pengadaan,
                            'verifikasi' => $inventaris->verified_at,
                        ];
                        $aset = Item::with('jenis')
                            ->where('inventaris_id', $inventaris->id)
                            ->get();
                        foreach ($aset as $key => $value) {
                            $data['aset'][$key] = [
                                'id' => $value->id,
                                'kode' => $value->id_item,
                                'nama' => $value->name,
                                'jenis' => $value->jenis->name,
                            ];
                        }
                        $data['jenis'] = 'Masuk';
                    } elseif ($inventaris->jenis_inventarisasi == 'keluar') {
                        $data['inventaris'] = [
                            'id' => $inventaris->id,
                            'kode' => $inventaris->kode_inventarisasi,
                            'jenis' => $inventaris->jenis_inventarisasi,
                            'tahun' => $inventaris->tahun_pengadaan,
                            'verifikasi' => $inventaris->verified_at,
                        ];
                        $aset = InventarisKeluar::with('aset', 'aset.jenis')
                            ->where('inventaris_id', $inventaris->id)
                            ->get();
                        foreach ($aset as $key => $value) {
                            $data['aset'][$key] = [
                                'id' => $value->aset->id,
                                'kode' => $value->aset->id_item,
                                'nama' => $value->aset->name,
                                'jenis' => $value->aset->jenis->name,
                                'keterangan' => $value->keterangan,
                            ];
                        }
                        $data['jenis'] = 'Keluar';
                    }
                    $pdf = PDF::loadView('pages.report.inventarisasi', $data)->setPaper('A4');
                    return $pdf->stream('report_inventarisasi_' . $inventaris->kode_inventarisasi . '-' . strtotime(date('Y-m-d H:i:s')) . '.pdf');
                } else {
                    return view('errors.403');
                }
            } else {
                return view('errors.403');
            }
        } else {
            return view('errors.403');
        }
    }
}
