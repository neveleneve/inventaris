<?php

namespace App\Livewire;

use Livewire\Component;

class DashboardGraphic extends Component {
    public $kategori;
    public $asetMasukPerJenisTable;
    public $asetKeluarPerJenisTable;

    public $graphMasuk = 1;
    public $graphKeluar = 1;

    public function render() {
        return view('livewire.dashboard-graphic');
    }
}
