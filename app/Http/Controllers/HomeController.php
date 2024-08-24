<?php

namespace App\Http\Controllers;

use App\Models\InventarisKeluar;
use App\Models\Item;
use Illuminate\Http\Request;

class HomeController extends Controller {
    public function __construct() {
        $this->middleware('permission:dashboard')->only('index');
    }

    public function index() {
        $asetTersedia = Item::with('inventaris', 'jenis')
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
            ->count();
        $asetTidakTersedia = InventarisKeluar::with('inventaris')
            ->whereHas('inventaris', function ($q) {
                $q->where('verified_at', '!=', null)
                    ->where('jenis_inventarisasi', 'keluar');
            })
            ->count();
        return view('home', [
            'asetok' => $asetTersedia,
            'asetnok' => $asetTidakTersedia
        ]);
    }
}
