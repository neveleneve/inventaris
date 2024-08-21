<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\JenisAset;
use Livewire\Attributes\Validate;
use Livewire\Component;

class InventarisCreate extends Component {

    // add data
    #[Validate('required')]
    public $jenisInv = null;
    // public $jenisInv = 'keluar';
    // public $jenisInv = 'masuk';

    #[Validate('required')]
    public $tahun = '';

    #region data aset masuk
    public $dataAsetTambah = [];
    public $jmlAset = 0;
    #endregion

    #region data aset keluar
    public $selectDataAset = [];
    public $selectDataAsetTerpilih = [];

    public $search = '';
    public $dataAset = [];
    public $tempSelectedDataAset = [];
    public $dataAsetTerpilih = [];
    public $tempSelectedDataAsetTerpilih = [];

    #endregion

    public function render() {
        $jenisAset = JenisAset::get();
        $this->dataAset = $this->getDataAset($this->search);

        return view('livewire.inventaris-create', [
            'jenisAset' => $jenisAset
        ]);
    }

    public function updatedJenisInv($value) {
        if ($value == 'keluar') {
            $this->dataAsetTambah = [];
            $this->jmlAset = 0;
        }
    }

    #region function aset masuk
    public function addAset() {
        $this->dataAsetTambah[$this->jmlAset] = [
            'nama' => '',
            'jenis' => '',
            'total' => 0,
        ];
        $this->jmlAset = count($this->dataAsetTambah);
    }

    public function deleteAset($index) {
        $dataAsetTambah = null;
        unset($this->dataAsetTambah[$index]);
        $i = 0;
        foreach ($this->dataAsetTambah as $value) {
            $dataAsetTambah[$i] = [
                'nama' => $value['nama'],
                'total' => $value['total'],
            ];
            $i++;
        }
        $this->dataAsetTambah = $dataAsetTambah;
        $this->jmlAset = count($this->dataAsetTambah);
    }
    #endregion

    #region function aset keluar
    public function getDataAset($search = '') {
        $returndata = [];
        $data = [];
        if ($search == '') {
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
                ->where(function ($query) use ($search) {
                    $query->where('id_item', 'LIKE', '%' . $search . '%')
                        ->orWhere('name', 'LIKE', '%' . $search . '%');
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

        foreach ($data as $value) {
            $returndata[] = [
                'id' => $value->id,
                'id_item' => $value->id_item,
                'name' => $value->name,
            ];
        }

        if (count($this->dataAsetTerpilih) > 0) {
            $dataReturn = $returndata;
            foreach ($this->dataAsetTerpilih as $key => $dat) {
                $data = $dat;
                foreach ($dataReturn as $key => $dr) {
                    if ($dr['id'] == $data['id']) {
                        unset($returndata[$key]);
                    }
                }
            }
        }

        return $returndata;
    }

    public function addAsetTerpilih() {
        if (count($this->dataAsetTerpilih) > 0) {
            foreach ($this->tempSelectedDataAset as $key => $value) {
                $this->tempSelectedDataAset[$key]['keterangan'] = '';
            }
            foreach ($this->tempSelectedDataAset as $key => $value) {
                array_push($this->dataAsetTerpilih, $value);
            }
        } else {
            foreach ($this->tempSelectedDataAset as $key => $value) {
                $this->tempSelectedDataAset[$key]['keterangan'] = '';
            }
            foreach ($this->tempSelectedDataAset as $key => $value) {
                $this->dataAsetTerpilih[$key] = $value;
            }
        }
        $this->tempSelectedDataAset = [];
        $this->selectDataAset = [];
    }

    public function deleteAsetTerpilih() {
        foreach ($this->dataAsetTerpilih as $key => $value) {
            for ($j = 0; $j < count($this->selectDataAsetTerpilih); $j++) {
                if ($value['id'] == $this->selectDataAsetTerpilih[$j]) {
                    unset($this->dataAsetTerpilih[$key]);
                }
            }
        }
        $this->tempSelectedDataAsetTerpilih = [];
        $this->selectDataAsetTerpilih = [];
    }

    public function updatedSelectDataAsetTerpilih($value, $key) {
        if ($value == '__rm__') {
            unset($this->tempSelectedDataAsetTerpilih[$key]);
        } else {
            $aset = Item::find($value);
            $this->tempSelectedDataAsetTerpilih[$key] = [
                'id' => $aset->id,
                'id_item' => $aset->id_item,
                'name' => $aset->name
            ];
        }
    }

    public function updatedSelectDataAset($value, $key) {
        if ($value == '__rm__') {
            unset($this->tempSelectedDataAset[$key]);
        } else {
            $asets = Item::find($value);
            $this->tempSelectedDataAset[$key] = [
                'id' => $asets->id,
                'id_item' => $asets->id_item,
                'name' => $asets->name,
            ];
        }
    }

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
