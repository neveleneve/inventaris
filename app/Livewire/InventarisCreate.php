<?php

namespace App\Livewire;

use App\Models\Inventaris;
use App\Models\InventarisKeluar;
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

    #[Validate('required_if:jenisInv,masuk', as: 'Tahun Masuk')]
    public $tahunMasuk = '';

    #[Validate('required_if:jenisInv,keluar', as: 'Tahun Keluar')]
    public $tahunKeluar = '';

    #region data aset masuk
    public $jmlAset = 0;
    #[Validate(
        [
            'dataAsetTambah' => 'required_if:jenisInv,masuk',
            'dataAsetTambah.*.nama' => 'required_if:jenisInv,masuk',
            'dataAsetTambah.*.jenis' => 'required_if:jenisInv,masuk',
            'dataAsetTambah.*.total' => 'required_if:jenisInv,masuk|gte:1|numeric',
        ],
        attribute: [
            'dataAsetTambah' => 'Data aset yang akan ditambah',
            'dataAsetTambah.*.nama' => 'Nama aset',
            'dataAsetTambah.*.jenis' => 'Jenis aset',
            'dataAsetTambah.*.total' => 'Total aset',
        ]
    )]
    public $dataAsetTambah = [];
    #endregion

    #region data aset keluar
    public $selectDataAset = [];
    public $selectDataAsetTerpilih = [];

    public $search = '';
    public $tempSelectedDataAset = [];
    public $dataAset = [];
    public $tempSelectedDataAsetTerpilih = [];
    #[Validate(
        [
            'dataAsetTerpilih' => 'required_if:jenisInv,keluar',
            'dataAsetTerpilih.*.keterangan' => [
                'required_if:jenisInv,keluar',
                'min:1'
            ]
        ],
        message: [
            'required' => ':attribute harus diisi',
            'required_if' => ':attribute harus diisi',
            'gte' => ':attribute harus diisi minimal :value',
            'numeric' => ':attribute harus diisi dengan angka!',
        ],
        attribute: [
            'dataAsetTerpilih' => 'Data aset yang dipilih',
            'dataAsetTerpilih.*.keterangan' => 'Keterangan data aset yang dipilih',
        ]
    )]
    public $dataAsetTerpilih = [];
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
            $this->tahunMasuk = '';
        } elseif ($value == 'masuk') {
            $this->tahunKeluar = '';
            $this->dataAsetTerpilih = [];
        }
    }

    public function clearData() {
        $this->jenisInv = null;
        $this->tahunMasuk = '';
        $this->tahunKeluar = '';
        $this->dataAsetTambah = [];
        $this->dataAsetTerpilih = [];
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
        $dataAsetTambah = [];
        unset($this->dataAsetTambah[$index]);
        $i = 0;
        foreach ($this->dataAsetTambah as $value) {
            $dataAsetTambah[$i] = [
                'nama' => $value['nama'],
                'jenis' => $value['jenis'],
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
            $addInventaris = Inventaris::create([
                'kode_inventarisasi' => $this->randomString(12),
                'tahun_pengadaan' => $this->tahunMasuk,
                'jenis_inventarisasi' => 'masuk',
            ]);
            if ($addInventaris) {
                foreach ($this->dataAsetTambah as $value) {
                    $total = $value['total'];
                    for ($i = 0; $i < $total; $i++) {
                        Item::create([
                            'name'          => $value['nama'],
                            'jenis_aset_id' => $value['jenis'],
                            'inventaris_id' => $addInventaris->id,
                            'id_item'       => $this->randomString(20),
                        ]);
                    }
                }
                $alert = [
                    'title' => 'Berhasil',
                    'text' => 'Berhasil menambah data inventaris masuk!',
                    'icon' => 'success',
                ];
            } else {
                $alert = [
                    'title' => 'Gagal',
                    'text' => 'Gagal menambah data inventaris masuk!',
                    'icon' => 'error',
                ];
            }
            $this->clearData();
            $this->dispatch('alert',  data: $alert);
        } elseif ($this->jenisInv == 'keluar') {
            $addInventaris = Inventaris::create([
                'kode_inventarisasi' => $this->randomString(12),
                'tahun_pengadaan' => $this->tahunKeluar,
                'jenis_inventarisasi' => 'keluar',
            ]);
            if ($addInventaris) {
                foreach ($this->dataAsetTerpilih as $value) {
                    InventarisKeluar::create([
                        'item_id' => $value['id'],
                        'inventaris_id' => $addInventaris->id,
                        'keterangan' => $value['keterangan'],
                    ]);
                }
                $alert = [
                    'title' => 'Berhasil',
                    'text' => 'Berhasil menambah data inventaris keluar!',
                    'icon' => 'success',
                ];
            } else {
                $alert = [
                    'title' => 'Gagal',
                    'text' => 'Gagal menambah data inventaris keluar!',
                    'icon' => 'error',
                ];
            }
            $this->clearData();
            $this->dispatch('alert', data: $alert);
        }
    }
    #endregion

    function randomString($length = 10) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkalmnopqrstuvwxyz';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $randomIndex = rand(0, strlen($characters) - 1);
            $string .= $characters[$randomIndex];
        }
        return $string;
    }
}
