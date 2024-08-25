<?php

namespace App\Livewire;

use App\Models\Inventaris;
use App\Models\InventarisKeluar;
use App\Models\Item;
use Illuminate\Pagination\Paginator;
use Livewire\Component;
use Livewire\WithPagination;

class InventarisIndex extends Component {
    use WithPagination;

    public $search = '';

    public $dataPerPage = 10;
    public $currentPage;

    public $dataInventaris = [
        'id' => '',
        'kode' => '',
        'jenis' => '',
        'tahun' => '',
        'tanggal' => '',
        'status' => '',
        'verifikasi' => '',
        'aset' => [],
    ];

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
        return view('livewire.inventaris-index', [
            'inventaris' => $data
        ]);
    }

    public function getDataInventaris(Inventaris $inventaris) {
        $this->dataInventaris = [
            'id' => $inventaris->id,
            'kode' => $inventaris->kode_inventarisasi,
            'jenis' => ucfirst($inventaris->jenis_inventarisasi),
            'tahun' => $inventaris->tahun_pengadaan,
            'tanggal' => $inventaris->created_at,
            'status' => $inventaris->verified_at ? 1 : 0,
            'verifikasi' => $inventaris->verified_at,
            'aset' => $inventaris->jenis_inventarisasi == 'masuk' ? $inventaris->aset : $inventaris->inventaris_keluar,
        ];
        $this->dispatch('open-modal', target: 'modalLihat');
    }

    public function verifikasi(Inventaris $inventaris) {
        if ($inventaris) {
            $inventaris->update([
                'verified_at' => date('Y-m-d H:i:s')
            ]);
            $alert = [
                'title' => 'Berhasil',
                'text' => 'Berhasil verifikasi inventarisasi ' . ucwords($inventaris->jenis_inventarisasi) . '!',
                'icon' => 'success',
            ];
        } else {
            $alert = [
                'title' => 'Gagal',
                'text' => 'Gagal verifikasi inventarisasi!',
                'icon' => 'error',
            ];
        }
        $this->dispatch('alert', data: $alert);
    }

    public function setPage($url) {
        $this->currentPage = explode('page=', $url)[1];
        Paginator::currentPageResolver(function () {
            return $this->currentPage;
        });
    }

    public function hapusInventaris(Inventaris $inventaris) {
        $id = $inventaris->id;
        $jenis = $inventaris->jenis_inventarisasi;

        $delete = $inventaris->delete();
        if ($delete) {
            if ($jenis == 'masuk') {
                Item::where('inventaris_id', $id)
                    ->delete();
            } elseif ($jenis == 'keluar') {
                InventarisKeluar::where('inventaris_id', $id)
                    ->delete();
            }
            $this->dispatch('alert', data: [
                'title' => 'Berhasil',
                'text' => 'Berhasil menghapus data inventarisasi',
                'icon' => 'success'
            ]);
        }
    }

    public function cetakInventarisasi(Inventaris $inventaris) {
        $route = route('report.inventaris', [
            'id' => $inventaris->id,
            'kode' => $inventaris->kode_inventarisasi
        ]);
        $this->dispatch('open-report', route: $route);
    }
}
