<?php

namespace App\Livewire;

use App\Models\JenisAset;
use Livewire\Component;

class InventarisCreate extends Component {
    public $jenisInv = null;

    public $dataAset = null;
    public $jmlAset = 0;
    // public $jenisAset;


    public function render() {
        $jenisAset = JenisAset::get();
        return view('livewire.inventaris-create', [
            'jenisAset' => $jenisAset
        ]);
    }

    public function addAset() {
        $this->dataAset[$this->jmlAset] = [
            'nama' => '',
            'jenis' => '',
            'total' => 0,
        ];
        $this->jmlAset = count($this->dataAset);
    }

    public function deleteAset($index) {
        $jmlAset = $this->jmlAset;
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
