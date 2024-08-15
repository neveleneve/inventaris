<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\JenisAset;
use Livewire\Attributes\Validate;
use Livewire\Component;

class InventarisCreate extends Component {

    // add data
    #[Validate('required')]
    // public $jenisInv = null;
    public $jenisInv = 'keluar';

    #[Validate('required')]
    public $tahun = '';

    #region data aset masuk
    public $dataAset = null;
    public $jmlAset = 0;
    #endregion
    #region data aset keluar
    public $search = '';
    #[Validate([
        'dataAsetKeluar' => 'required_if:jenisInv,keluar',
        'dataAsetKeluar.*' => [
            'required_if:jenisInv,keluar'
        ],
    ])]
    public $dataAsetKeluar = [];
    #endregion

    public function render() {
        $jenisAset = JenisAset::get();
        if ($this->search == '') {
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
                ->get();
        }
        return view('livewire.inventaris-create', [
            'jenisAset' => $jenisAset,
            'aset' => $data,
        ]);
    }

    #region function aset masuk
    public function addAset() {
        $this->dataAset[$this->jmlAset] = [
            'nama' => '',
            'jenis' => '',
            'total' => 0,
        ];
        $this->jmlAset = count($this->dataAset);
    }

    public function deleteAset($index) {
        $dataAset = null;
        unset($this->dataAset[$index]);
        $i = 0;
        foreach ($this->dataAset as $value) {
            $dataAset[$i] = [
                'nama' => $value['nama'],
                'total' => $value['total'],
            ];
            $i++;
        }
        $this->dataAset = $dataAset;
        $this->jmlAset = count($this->dataAset);
    }

    public function updatedJenisInv() {
        $this->dataAset = null;
        $this->jmlAset = 0;
    }
    #endregion

    #region function aset keluar

    #endregion

    #region save data
    public function save() {
        $this->validate();
        if ($this->jenisInv == 'masuk') {
            # code...
        } elseif ($this->jenisInv == 'keluar') {
            # code...
        }
    }
    #endregion

    function randomString($length = 10) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkalmnopqrstuvwxyz';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $randomIndex = rand(0, strlen($characters) - 1);
            $string .= $characters[$randomIndex];
        }
        return $string;
    }
}
