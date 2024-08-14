<div>
    <div class="col-lg-12 mb-2">
        <input wire:model.live='search' type="text" class="form-control rounded-5" placeholder="Pencarian..."
            id="search">
    </div>
    @include('layouts.dataperpage')
    <div class="col-lg-12 justify-content-center" wire:loading wire:loading.class='d-flex' wire:loading.target='search'>
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="table-responsive" wire:loading.remove>
            <table class="table table-bordered text-center text-nowrap">
                <thead class="table-dark">
                    <tr>
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
                            <td>{{ $item->id_item }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->inventaris->tahun_pengadaan }}</td>
                            @canany(['aset show', 'aset edit'])
                                <td>
                                    <div class="btn-group" role="group">
                                        @can('aset show')
                                            <a href="{{ route('aset.show', ['aset' => $item->id]) }}"
                                                class="btn btn-sm btn-primary fw-bold" data-bs-toggle="modal"
                                                data-bs-target="#modalLihat" wire:click='getDataAset({{ $item->id }})'>
                                                Lihat
                                            </a>
                                        @endcan
                                        @can('aset edit')
                                            <a href="{{ route('aset.edit', ['aset' => $item->id]) }}"
                                                class="btn btn-sm btn-warning fw-bold">
                                                Ubah
                                            </a>
                                        @endcan
                                    </div>
                                </td>
                            @endcanany
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
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
                    <input type="text" id="kode" class="form-control mb-3" wire:model='dataAset.kode'>
                    <label for="nama" class="fw-bold">Nama Aset</label>
                    <input type="text" id="nama" class="form-control mb-3" wire:model='dataAset.nama'>
                    <label for="jenis" class="fw-bold">Jenis Aset</label>
                    <input type="text" id="jenis" class="form-control mb-3" wire:model='dataAset.jenis'>
                    <label for="nama" class="fw-bold">Tahun Anggaran</label>
                    <input type="text" id="tahun" class="form-control mb-3" wire:model='dataAset.tahun'>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>
