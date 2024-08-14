<div>
    <div class="col-lg-12 mb-2">
        <input type="text" class="form-control rounded-5" placeholder="Pencarian..." id="search"
            wire:model.live='search'>
    </div>
    @include('layouts.dataperpage')
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-bordered text-center text-nowrap">
                <thead class="table-dark">
                    <tr>
                        <th>Kode Inventarisasi</th>
                        <th>Jenis Inventarisasi</th>
                        <th>Jumlah Aset</th>
                        <th>Tahun Pengadaan</th>
                        <th>Tanggal Pencatatan</th>
                        <th>Tanggal Verifikasi</th>
                        @canany(['aset show', 'aset edit'])
                            <th></th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @forelse ($inventaris as $item)
                        <tr>
                            <td>{{ $item->kode_inventarisasi }}</td>
                            <td>
                                {{ $item->jenis_inventarisasi == 'masuk' ? 'Masuk / Penambahan' : 'Keluar / Pengurangan' }}
                            </td>
                            <td>
                                {{ $item->jenis_inventarisasi == 'masuk' ? $item->aset_count : $item->inventaris_keluar_count }}
                            </td>
                            <td>{{ $item->tahun_pengadaan }}</td>
                            <td>{{ date('d F Y, H:i:s', strtotime($item->created_at)) }}</td>
                            <td>{{ $item->verified_at ? date('d F Y, H:i:s', strtotime($item->verified_at)) : '-' }}
                            </td>
                            @canany(['inventaris show', 'inventaris edit'])
                                <td>
                                    <div class="btn-group" role="group">
                                        @can('inventaris show')
                                            <a href="{{ route('inventaris.show', ['inventari' => $item->id]) }}"
                                                class="btn btn-sm btn-primary fw-bold">
                                                Lihat
                                            </a>
                                        @endcan
                                        @can('inventaris edit')
                                            <a href="{{ route('inventaris.edit', ['inventari' => $item->id]) }}"
                                                class="btn btn-sm btn-warning fw-bold">
                                                Ubah
                                            </a>
                                        @endcan
                                        @if (!$item->verified_at)
                                            @can('inventaris delete')
                                                <a href="{{ route('inventaris.destroy', ['inventari' => $item->id]) }}"
                                                    class="btn btn-sm btn-danger fw-bold">
                                                    Hapus
                                                </a>
                                            @endcan
                                        @endif
                                    </div>
                                </td>
                            @endcanany
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <h2 class="text-center fw-bold">Data Kosong</h2>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-12">
        {{ $inventaris->links('layouts.pagination') }}
    </div>
</div>
