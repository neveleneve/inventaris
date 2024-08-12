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

    public function render() {
        if ($this->search == '') {
            $data = Item::with('inventaris', 'jenis')
                ->paginate($this->dataPerPage);
        } else {
            $data = Item::with('inventaris', 'jenis')
                ->where('id_item', 'LIKE', '%' . $this->search . '%')
                ->orWhere('name', 'LIKE', '%' . $this->search . '%')
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
}
