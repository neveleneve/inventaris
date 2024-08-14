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
}
