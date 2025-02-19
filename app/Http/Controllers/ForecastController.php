<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ForecastController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {

        return view('pages.peramalan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        //
    }

    function getActualDataByCat($kategori_id, $period = 5) {
        $tahun = date('Y');
        $years = range($tahun - ($period - 1), $tahun);
        $result = [];
        $masuk = Item::with(['inventaris', 'jenis'])
            ->whereHas('inventaris', function ($q) use ($years) {
                $q
                    ->whereIn('tahun_pengadaan', $years)
                    ->where('verified_at', '!=', null)
                    ->where('jenis_inventarisasi', 'masuk');
            })
            ->whereDoesntHave('inventaris_keluar')
            ->get();

        foreach ($years as $year) {
            $result[] = $masuk
                ->where('jenis_aset_id', $kategori_id)
                ->where('inventaris.tahun_pengadaan', $year)
                ->count();
        }
        return $result;
    }

    function exponentialMovingAverage($data, $days = 3) {
        $totaldata = count($data);

        $ema = [];

        for ($i = 0; $i < $totaldata; $i++) {
            if ($i == 0) {
                $ema[$i] = floatval(number_format($data[$i], 2, '.', ''));
            } else {
                $ema[$i] = floatval(number_format(($data[$i] * (2 / ($days + 1))) + ($ema[$i - 1] * (1 - (2 / ($days + 1)))), 2, '.', ''));
            }
        }

        return $ema;
    }

    function simpleMovingAverage($data, $days = 3) {
        $totaldata = count($data);

        $sma = [];

        for ($i = 0; $i < $totaldata; $i++) {
            if ($i < $days - 1) {
                $sma[$i] = 0.0;
            } else {
                $sma[$i] = floatval(number_format(array_sum(array_slice($data, $i - ($days - 1), $days)) / $days, 2, '.', ''));
            }
        }

        return $sma;
    }
}
