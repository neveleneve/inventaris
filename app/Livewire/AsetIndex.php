<?php

namespace App\Livewire;

use App\Models\Item;
use Illuminate\Pagination\Paginator;
use Livewire\Component;
use Livewire\WithPagination;

class AsetIndex extends Component {
    use WithPagination;

    public $search = '';

    public $dataPerPage = 10;
    public $currentPage;

    public $dataAset = [
        'kode' => '',
        'nama' => '',
        'tahun' => '',
        'jenis' => '',
    ];

    public function render() {
        if ($this->search == '') {
            $data = Item::with('inventaris', 'jenis')
                ->whereHas('inventaris', function ($q) {
                    $q->where('verified_at', '!=', null)
                        ->where('jenis_inventarisasi', 'masuk');
                })
                ->paginate($this->dataPerPage);
        } else {
            $data = Item::with('inventaris', 'jenis')
                ->where(function ($query) {
                    $query->where('id_item', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('name', 'LIKE', '%' . $this->search . '%');
                })
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
                ->paginate($this->dataPerPage);
        }
        return view('livewire.aset-index', [
            'items' => $data
        ]);
    }

    public function setPage($url) {
        $this->currentPage = explode('page=', $url)[1];
        Paginator::currentPageResolver(function () {
            return $this->currentPage;
        });
    }

    public function getDataAset(Item $item) {
        $this->dataAset = [
            'kode' => $item->id_item,
            'nama' => $item->name,
            'tahun' => $item->inventaris->tahun_pengadaan,
            'kode_inventaris' => $item->inventaris->kode_inventarisasi,
            'jenis' => $item->jenis->name,
        ];

        $this->dispatch('open-modal');
    }
}
