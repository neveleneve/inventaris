<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;

class ReportIndex extends Component {
    #[Validate('required', as: 'Jenis Laporan')]
    public $jenisReport = '';

    #[Validate('required_if:jenisReport,tahun', as: 'Tahun Anggaran / Pencatatan')]
    public $tahun = '';
    #[Validate('required_if:jenisReport,asetMasuk', as: 'Tahun Anggaran / Pencatatan')]
    public $tahunMasuk = '';
    #[Validate('required_if:jenisReport,asetKeluar', as: 'Tahun Anggaran / Pencatatan', message: [
        'required' => ':attribute harus diisi',
        'required_if' => ':attribute harus diisi',
    ])]
    public $tahunKeluar = '';


    public function render() {
        return view('livewire.report-index');
    }

    public function cetak() {
        $this->validate();
        $route = '';
        if ($this->jenisReport == 'tahunan') {
            $route = route('report.cetak', [
                'jenis' => $this->jenisReport,
                'tahun' => $this->tahun,
            ]);
        } elseif ($this->jenisReport == 'aset_masuk') {
            $route = route('report.cetak', [
                'jenis' => $this->jenisReport,
                'tahun' => $this->tahunMasuk,
            ]);
        } elseif ($this->jenisReport == 'aset_keluar') {
            $route = route('report.cetak', [
                'jenis' => $this->jenisReport,
                'tahun' => $this->tahunKeluar,
            ]);
        } elseif ($this->jenisReport == 'aset_tersedia') {
            $route = route('report.cetak', [
                'jenis' => $this->jenisReport
            ]);
        }


        $this->dispatch('open-report', route: $route);
        $this->resetForm();
    }

    public function resetForm() {
        $this->jenisReport = '';
        $this->tahun = '';
        $this->tahunMasuk = '';
        $this->tahunKeluar = '';
    }
}
