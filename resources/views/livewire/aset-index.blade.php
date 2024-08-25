<div>
    <div class="col-lg-12 mb-2">
        <input wire:model.live='search' type="text" class="form-control rounded-5" placeholder="Pencarian..."
            id="search">
    </div>
    @include('layouts.dataperpage')
    <div class="col-lg-12 justify-content-center" wire:loading wire:loading.class='d-flex'
        wire:target.except='getDataAset'>
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="table-responsive" wire:loading.remove wire:target.except='getDataAset'>
            <table class="table table-bordered text-center text-nowrap">
                <thead class="table-dark">
                    <tr>
                        <th>Kode Inventarisasi</th>
                        <th>Kode Aset</th>
                        <th>Nama</th>
                        <th>Tahun Pengadaan</th>
                        @canany(['aset show', 'aset edit'])
                            <th></th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <td>{{ $item->inventaris->kode_inventarisasi }}</td>
                            <td>{{ $item->id_item }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->inventaris->tahun_pengadaan }}</td>
                            @canany(['aset show', 'aset edit'])
                                <td>
                                    <div class="btn-group" role="group">
                                        @can('aset show')
                                            <button class="btn btn-sm btn-primary fw-bold"
                                                wire:click='getDataAset({{ $item->id }})'>
                                                Lihat
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            @endcanany
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
                                <h2 class="text-center fw-bold">Data Kosong</h2>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-12">
        {{ $items->links('layouts.pagination') }}
    </div>
    <div class="modal modal-lg fade" id="modalLihat" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="exampleModalLabel">Data Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="kode" class="fw-bold">Kode Aset</label>
                    <input type="text" id="kode" class="form-control mb-3" wire:model='dataAset.kode' readonly>
                    <label for="nama" class="fw-bold">Nama Aset</label>
                    <input type="text" id="nama" class="form-control mb-3" wire:model='dataAset.nama' readonly>
                    <label for="jenis" class="fw-bold">Jenis Aset</label>
                    <input type="text" id="jenis" class="form-control mb-3" wire:model='dataAset.jenis' readonly>
                    <label for="kode_inv" class="fw-bold">Kode Inventarisasi</label>
                    <input type="text" id="kode_inv" class="form-control mb-3" wire:model='dataAset.kode_inventaris'
                        readonly>
                    <label for="tahun" class="fw-bold">Tahun Anggaran</label>
                    <input type="text" id="tahun" class="form-control" wire:model='dataAset.tahun' readonly>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger rounded-5 fw-bold" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('customjs')
    <script>
        Livewire.on('open-modal', event => {
            const modal = new bootstrap.Modal(document.getElementById('modalLihat'));
            modal.show();
        });
    </script>
@endpush
