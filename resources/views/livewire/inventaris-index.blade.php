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
                        @canany(['inventaris show'])
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
                            <td>{{ $item->verified_at ? date('d F Y, H:i:s', strtotime($item->verified_at)) : 'Belum Diverifikasi' }}
                            </td>
                            @canany(['inventaris show'])
                                <td>
                                    <div class="btn-group" role="group">
                                        @can('inventaris show')
                                            <button class="btn btn-sm btn-primary fw-bold"
                                                wire:click='getDataInventaris({{ $item->id }})'>
                                                Lihat
                                            </button>
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
    <div class="modal modal-lg fade" id="modalLihat" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="exampleModalLabel">Data Inventarisasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="kode" class="fw-bold">Kode Inventarisasi</label>
                    <input type="text" id="kode" class="form-control mb-3" readonly
                        wire:model='dataInventaris.kode'>
                    <label for="jenis" class="fw-bold">Jenis Inventarisasi</label>
                    <input type="text" id="jenis" class="form-control mb-3" readonly
                        wire:model='dataInventaris.jenis'>
                    <label for="tahun" class="fw-bold">Tahun Pengadaan</label>
                    <input type="text" id="tahun" class="form-control mb-3" readonly
                        wire:model='dataInventaris.tahun'>
                    <label for="tanggal" class="fw-bold">Tanggal Pencatatan</label>
                    <input type="text" id="tanggal" class="form-control mb-3" readonly
                        value="{{ date('d F Y, H:i:s', strtotime($dataInventaris['tanggal'])) }}">
                    <label for="status" class="fw-bold">Status Verifikasi</label>
                    <input type="text" id="status" class="form-control mb-3" readonly
                        value="{{ $dataInventaris['status'] ? 'Terverifikasi' : 'Belum Verifikasi' }}">
                    @if ($dataInventaris['status'])
                        <label for="verifikasi" class="fw-bold">Tanggal Verifikasi</label>
                        <input type="text" id="verifikasi" class="form-control mb-3" readonly
                            value="{{ date('d F Y, H:i:s', strtotime($dataInventaris['verifikasi'])) }}">
                    @endif
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered text-nowrap">
                            <thead class="table-dark">
                                <tr>
                                    <th>Kode Aset</th>
                                    <th>Nama</th>
                                    @if ($dataInventaris['jenis'] == 'keluar')
                                        <th>Keterangan</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if ($dataInventaris['jenis'] == 'masuk')
                                    @forelse ($dataInventaris['aset'] as $item)
                                        <tr>
                                            <td>{{ $item->id_item }}</td>
                                            <td>{{ $item->name }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">
                                                <h3 class="text-center">Data Kosong</h3>
                                            </td>
                                        </tr>
                                    @endforelse
                                @elseif ($dataInventaris['jenis'] == 'keluar')
                                    @forelse ($dataInventaris['aset'] as $itemm)
                                        <tr>
                                            <td>{{ $itemm->aset->id_item }}</td>
                                            <td>{{ $itemm->aset->name }}</td>
                                            <td class="text-wrap">{{ $itemm->keterangan }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">
                                                <h3 class="text-center">Data Kosong</h3>
                                            </td>
                                        </tr>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    @if (!$item->verified_at)
                        @can('inventaris verification')
                            <button class="btn btn-success rounded-5 fw-bold">
                                Verifikasi
                            </button>
                        @endcan
                    @endif
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
