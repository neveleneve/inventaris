<div>
    <div class="col-lg-12 mb-2">
        <input wire:model.live='search' type="text" class="form-control rounded-5" placeholder="Pencarian..."
            id="search">
    </div>
    @include('layouts.dataperpage')
    <div class="col-lg-12">
        <div class="table-responsive">
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
                                                class="btn btn-primary fw-bold">
                                                Lihat
                                            </a>
                                        @endcan
                                        @can('aset edit')
                                            <a href="{{ route('aset.edit', ['aset' => $item->id]) }}"
                                                class="btn btn-warning fw-bold">
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
</div>
