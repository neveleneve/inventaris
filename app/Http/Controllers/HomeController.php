<?php

namespace App\Http\Controllers;

use App\Models\InventarisKeluar;
use App\Models\Item;
use App\Models\JenisAset;
use Illuminate\Http\Request;

class HomeController extends Controller {
    public function __construct() {
        $this->middleware('permission:dashboard')->only('index');
    }

    public function index() {
        $kategori = JenisAset::get();
        $tahun = date('Y');
        $years = range($tahun - 4, $tahun);

        $asetMasukPerJenis = [];
        $masuk = Item::with(['inventaris', 'jenis'])
            ->whereHas('inventaris', function ($q) use ($years) {
                $q->whereIn('tahun_pengadaan', $years)
                    ->where('verified_at', '!=', null)
                    ->where('jenis_inventarisasi', 'masuk');
            })
            ->whereDoesntHave('inventaris_keluar')
            ->get();

        foreach ($kategori as $jenis) {
            foreach ($years as $year) {
                $asetMasukPerJenis[$jenis->id][$year] = $masuk
                    ->where('jenis_aset_id', $jenis->id)
                    ->where('inventaris.tahun_pengadaan', $year)
                    ->count();
            }
        }

        $asetKeluarPerJenis = [];
        foreach ($kategori as $jenis) {
            foreach ($years as $year) {
                $asetKeluarPerJenis[$jenis->id][$year] = InventarisKeluar::with(['aset', 'aset.jenis', 'inventaris'])
                    ->whereHas('inventaris', function ($q) use ($years, $year) {
                        $q->whereIn('tahun_pengadaan', $years)
                            ->where('tahun_pengadaan', $year)
                            ->where('verified_at', '!=', null)
                            ->where('jenis_inventarisasi', 'keluar');
                    })
                    ->whereHas('aset.jenis', function ($q) use ($jenis) {
                        $q->where('jenis_aset_id', $jenis->id);
                    })
                    ->count();
            }
        }

        $asetMasukPerJenisTable = [];
        $iampjt = 0;
        foreach ($years as $year) {
            $asetMasukPerJenisTable[$iampjt]['tahun'] = $year;
            foreach ($kategori as $jenis) {
                $asetMasukPerJenisTable[$iampjt]['data'][$jenis->id] = $masuk
                    ->where('jenis_aset_id', $jenis->id)
                    ->where('inventaris.tahun_pengadaan', $year)
                    ->count();
            }
            $iampjt++;
        }

        $asetKeluarPerJenisTable = [];
        $iakpjt = 0;
        foreach ($years as $year) {
            $asetKeluarPerJenisTable[$iakpjt]['tahun'] = $year;
            foreach ($kategori as $jenis) {
                $asetKeluarPerJenisTable[$iakpjt]['data'][$jenis->id] = InventarisKeluar::with(['aset', 'aset.jenis', 'inventaris'])
                    ->whereHas('inventaris', function ($q) use ($years, $year) {
                        $q->whereIn('tahun_pengadaan', $years)
                            ->where('tahun_pengadaan', $year)
                            ->where('verified_at', '!=', null)
                            ->where('jenis_inventarisasi', 'keluar');
                    })
                    ->whereHas('aset.jenis', function ($q) use ($jenis) {
                        $q->where('jenis_aset_id', $jenis->id);
                    })
                    ->count();
            }
            $iakpjt++;
        }

        $asetTersedia = Item::with('inventaris', 'jenis')
            ->whereHas('inventaris', function ($q) {
                $q
                    ->where('verified_at', '!=', null)
                    ->where('jenis_inventarisasi', 'masuk');
            })
            ->whereDoesntHave('inventaris_keluar', function ($q) {
                $q->whereHas('inventaris', function ($subQuery) {
                    $subQuery->where('jenis_inventarisasi', 'keluar')
                        ->where('verified_at', '!=', null);
                });
            })
            ->count();
        $asetTidakTersedia = InventarisKeluar::with('inventaris')
            ->whereHas('inventaris', function ($q) {
                $q
                    ->where('verified_at', '!=', null)
                    ->where('jenis_inventarisasi', 'keluar');
            })
            ->count();
        return view('home', [
            'asetok' => $asetTersedia,
            'asetnok' => $asetTidakTersedia,
            'kategori' => $kategori,
            'asetMasukPerJenis' => $asetMasukPerJenis,
            'asetMasukPerJenisTable' => $asetMasukPerJenisTable,
            'asetKeluarPerJenis' => $asetKeluarPerJenis,
            'asetKeluarPerJenisTable' => $asetKeluarPerJenisTable,
        ]);
    }
}
