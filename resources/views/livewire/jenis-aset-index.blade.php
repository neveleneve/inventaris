<div>
    <div class="col-lg-12 mb-2">
        <input wire:model.live='search' type="text" class="form-control rounded-5" placeholder="Pencarian..."
            id="search">
    </div>
    @include('layouts.dataperpage')
    <div class="col-lg-12 justify-content-center" wire:loading wire:loading.class='d-flex'
        wire:target.except='getDataJenisAset'>
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="col-lg-12 d-none d-xl-inline">
        <div class="table-responsive" wire:loading.remove wire:target.except='getDataJenisAset'>
            <table class="table table-bordered text-center text-nowrap">
                <thead class="table-dark">
                    <tr>
                        <th>Nama</th>
                        @canany(['jenis aset show', 'jenis aset edit'])
                            <th></th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jenisAset as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            @canany(['jenis aset show', 'jenis aset edit'])
                                <td>
                                    <div class="btn-group" role="group">
                                        @can('aset show')
                                            <button class="btn btn-sm btn-primary fw-bold"
                                                wire:click='getDataJenisAset({{ $item->id }})'>
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
    <div class="col-lg-12 d-inline d-xl-none">
        <div wire:loading.remove wire:target.except='getDataJenisAset'>
            @forelse ($jenisAset as $item)
                <div class="card mb-3 shadow-sm border-bottom">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <p class="fw-bold mb-1">Nama:</p>
                                <p class="text-muted">{{ $item->name }}</p>
                            </div>
                            @canany(['aset show', 'aset edit'])
                                <div class="col-12 mt-2">
                                    @can('aset show')
                                        <button class="btn btn-primary btn-sm fw-bold w-100"
                                            wire:click='getDataJenisAset({{ $item->id }})'>
                                            Lihat
                                        </button>
                                    @endcan
                                </div>
                            @endcanany
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-4">
                    <h2 class="fw-bold">Data Kosong</h2>
                </div>
            @endforelse
        </div>
    </div>
    <div class="col-lg-12">
        {{ $jenisAset->links('layouts.pagination') }}
    </div>
    <div class="modal modal-lg fade" id="modalLihat" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="exampleModalLabel">Data Jenis Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="nama" class="fw-bold">Nama Jenis Aset</label>
                    <input type="text" id="nama" class="form-control mb-3" wire:model='dataJenisAset.nama'
                        readonly>
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
