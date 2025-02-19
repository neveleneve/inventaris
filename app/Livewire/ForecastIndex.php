<?php

namespace App\Livewire;

use App\Models\InventarisKeluar;
use App\Models\Item;
use App\Models\JenisAset;
use Livewire\Component;

class ForecastIndex extends Component {
    public $choosenCategory = 1;
    public $dataTotal = 10;
    public $period = 3;
    public $inventType = 'masuk';
    public $methodType = 'sma';
    public $graph = 1;
    public $category;

    public $chartData;

    public function mount() {
        $datax = collect($this->getData($this->choosenCategory, $this->dataTotal, $this->period, $this->inventType, $this->methodType));
        $this->updateChartData($datax);
        $this->category = JenisAset::all();
    }

    public function render() {
        $datax = collect($this->getData($this->choosenCategory, $this->dataTotal, $this->period, $this->inventType, $this->methodType));
        return view('livewire.forecast-index', [
            'data' => $datax,
            'chartData' => $this->chartData,
            'cat_name' => $this->categoryName($this->choosenCategory),
        ]);
    }

    public function getData($choosenCategory, $dataTotal, $period, $inventType, $methodType) {
        $actualData = $this->getActualDataByCat($choosenCategory, $dataTotal, $period, $inventType, $methodType);
        $ma = [];
        $data = [];
        if ($methodType == 'sma') {
            $ma = $this->simpleMovingAverage($actualData, $period);
        } elseif ($methodType == 'ema') {
            $ma = $this->exponentialMovingAverage($actualData, $period);
        }
        for ($i = 0; $i < $dataTotal; $i++) {
            $data[$i] = [
                'tahun' => date('Y') - ($dataTotal - 1) + $i,
                'actual' => $actualData[$i],
                'forecast' => $ma[$i],
            ];
        }
        return $data;
    }

    function getActualDataByCat($kategori_id, $dataTotal = 10, $period = 5, $inventType = 'masuk') {
        $tahun = date('Y');
        $years = range($tahun - ($dataTotal - 1), $tahun);
        $result = [];
        if ($inventType == 'masuk') {
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
        } elseif ($inventType == 'keluar') {
            foreach ($years as $year) {
                $result[] = InventarisKeluar::with(['aset', 'aset.jenis', 'inventaris'])
                    ->whereHas('inventaris', function ($q) use ($years, $year) {
                        $q->whereIn('tahun_pengadaan', $years)
                            ->where('tahun_pengadaan', $year)
                            ->where('verified_at', '!=', null)
                            ->where('jenis_inventarisasi', 'keluar');
                    })
                    ->whereHas('aset.jenis', function ($q) use ($kategori_id) {
                        $q->where('jenis_aset_id', $kategori_id);
                    })
                    ->count();
            }
        }
        return $result;
    }

    function exponentialMovingAverage($data, $period) {
        $totaldata = count($data);

        $ema = [];

        for ($i = 0; $i < $totaldata; $i++) {
            if ($i == 0) {
                $ema[$i] = floatval(number_format($data[$i], 2, '.', ''));
            } else {
                $ema[$i] = floatval(number_format(($data[$i] * (2 / ($period + 1))) + ($ema[$i - 1] * (1 - (2 / ($period + 1)))), 2, '.', ''));
            }
        }

        return $ema;
    }

    function simpleMovingAverage($data, $period) {
        $totaldata = count($data);

        $sma = [];

        for ($i = 0; $i < $totaldata; $i++) {
            if ($i < $period - 1) {
                $sma[$i] = 0.0;
            } else {
                $sma[$i] = floatval(number_format(array_sum(array_slice($data, $i - ($period - 1), $period)) / $period, 2, '.', ''));
            }
        }

        return $sma;
    }

    function categoryName($kategori_id) {
        return JenisAset::find($kategori_id)->name;
    }

    public function updated($property) {
        if (in_array($property, ['choosenCategory', 'dataTotal', 'period', 'inventType', 'methodType'])) {
            $datax = collect($this->getData($this->choosenCategory, $this->dataTotal, $this->period, $this->inventType, $this->methodType));
            $this->updateChartData($datax);
        }
    }

    private function updateChartData($datax) {
        $this->chartData = [
            'labels' => $datax->pluck('tahun')->toArray(),
            'datasets' => [
                [
                    'type' => 'line',
                    'label' => 'Data Peramalan',
                    'backgroundColor' => '#7CB9E8',
                    'borderColor' => '#7CB9E8',
                    'data' => $datax->pluck('forecast')->toArray(),
                    'fill' => false,
                    'pointRadius' => 5,
                ],
                [
                    'type' => 'line',
                    'label' => 'Data Aktual',
                    'backgroundColor' => '#F87979',
                    'borderColor' => '#F87979',
                    'data' => $datax->pluck('actual')->toArray(),
                    'fill' => false,
                    'pointRadius' => 8,
                ],
            ],
        ];
        $this->dispatch('chartUpdated', chartData: $this->chartData);
    }
}
