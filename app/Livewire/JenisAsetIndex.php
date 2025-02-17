<?php

namespace App\Livewire;

use App\Models\JenisAset;
use Illuminate\Pagination\Paginator;
use Livewire\Component;
use Livewire\WithPagination;

class JenisAsetIndex extends Component {
    use WithPagination;

    public $search = '';

    public $dataPerPage = 5;
    public $currentPage;

    public $dataJenisAset = [
        'nama' => '',
    ];

    public function render() {
        if ($this->search == '') {
            $data = JenisAset::paginate($this->dataPerPage);
        } else {
            $data = JenisAset::with('inventaris', 'jenis')
                ->where('name', 'LIKE', '%' . $this->search . '%')
                ->paginate($this->dataPerPage);
        }
        return view('livewire.jenis-aset-index', [
            'jenisAset' => $data
        ]);
    }

    public function setPage($url) {
        $this->currentPage = explode('page=', $url)[1];
        Paginator::currentPageResolver(function () {
            return $this->currentPage;
        });
    }

    public function getDataJenisAset(JenisAset $jenisAset) {
        $this->dataJenisAset = [
            'nama' => $jenisAset->name,
        ];
        $this->dispatch('open-modal');
    }
}
