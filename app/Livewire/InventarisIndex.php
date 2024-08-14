<?php

namespace App\Livewire;

use App\Models\Inventaris;
use Livewire\Component;
use Livewire\WithPagination;

class InventarisIndex extends Component {
    use WithPagination;

    public $search = '';

    public $dataPerPage = 10;
    public $currentPage;

    public $dataInventaris = [
        'kode' => '',
        'jenis' => '',
        'tahun' => '',
        'tanggal' => '',
        'status' => '',
        'verifikasi' => '',
        'aset' => [],
    ];

    public function render() {
        if ($this->search == '') {
            $data = Inventaris::with('aset', 'inventaris_keluar')
                ->withCount('aset', 'inventaris_keluar')
                ->paginate($this->dataPerPage);
        } else {
            $data = Inventaris::with('aset', 'inventaris_keluar')
                ->withCount('aset', 'inventaris_keluar')
                ->where('kode_inventarisasi', 'LIKE', '%' . $this->search . '%')
                ->orWhere('tahun_pengadaan', 'LIKE', '%' . $this->search . '%')
                ->paginate($this->dataPerPage);
        }
        // dd($data);
        return view('livewire.inventaris-index', [
            'inventaris' => $data
        ]);
    }

    public function getDataInventaris($id) {
        $inventaris = Inventaris::with('aset', 'inventaris_keluar', 'inventaris_keluar.aset')->find($id);
        $this->dataInventaris = [
            'kode' => $inventaris->kode_inventarisasi,
            'jenis' => ucfirst($inventaris->jenis_inventarisasi),
            'tahun' => $inventaris->tahun_pengadaan,
            'tanggal' => $inventaris->created_at,
            'status' => $inventaris->verified_at ? 1 : 0,
            'verifikasi' => $inventaris->verified_at,
            'aset' => $inventaris->jenis_inventarisasi == 'masuk' ? $inventaris->aset : $inventaris->inventaris_keluar,
        ];
        // dd($inventaris->inventaris_keluar);
        // dd($this->dataInventaris);
        $this->dispatch('open-modal');
    }
}
