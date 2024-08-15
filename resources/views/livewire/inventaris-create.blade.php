<div>
    <div class="row justify-content-center">
        <div class="col-12 mb-3">
            <label for="jenis" class="fw-bold">Jenis Inventarisasi</label>
            <select name="jenis" id="jenis" class="form-select rounded-5" wire:model.live='jenisInv'>
                <option value="" selected hidden>Pilih Jenis Inventarisasi</option>
                <option value="masuk">Masuk / Penambahan</option>
                <option value="keluar">Keluar / Pengurangan</option>
            </select>
        </div>
        <div class="col-lg-12 justify-content-center" wire:loading wire:loading.class='d-flex'
            wire:target.except='addAset, dataAsetKeluar, search, toggleTextarea'>
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        @if ($jenisInv == 'masuk')
            <div wire:loading.remove wire:target='jenisInv' wire:target.except='addAset'>
                <div class="col-12 mb-3">
                    <label for="tahun" class="fw-bold">Tahun Pengadaan Inventaris</label>
                    <select name="tahun" id="tahun" class="form-select rounded-5">
                        <option value="" selected hidden>Pilih Tahun Pengadaan Inventaris</option>
                        @for ($i = 5; $i >= 0; $i--)
                            <option value="{{ date('Y') - $i }}">{{ date('Y') - $i }}</option>
                        @endfor
                    </select>
                    <hr class="mb-0">
                </div>
                <div class="col-12 mb-3">
                    <table class="table table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th></th>
                                <th>Nama Aset</th>
                                <th>Jenis Aset</th>
                                <th>Jumlah Aset</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($jmlAset > 0)
                                @for ($i = 0; $i < count($dataAset); $i++)
                                    <tr>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-danger rounded-5"
                                                wire:click='deleteAset({{ $i }})'>
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="namaaset{{ $i }}"
                                                name="namaaset[]" placeholder="Nama Aset"
                                                wire:model.live='dataAset.{{ $i }}.nama'>
                                        </td>
                                        <td>
                                            <select name="jenisaset[]" id="jenisaset{{ $i }}"
                                                class="form-select">
                                                <option value="">Pilih Jenis Aset</option>
                                                @foreach ($jenisAset as $jenis)
                                                    <option value="{{ $jenis->id }}">{{ $jenis->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" id="totalaset{{ $i }}"
                                                name="totalaset[]" placeholder="Total Aset"
                                                wire:model.live='dataAset.{{ $i }}.total'>
                                        </td>
                                    </tr>
                                @endfor
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <button class="btn btn-outline-success fw-bold rounded-5" wire:click='addAset'>
                                            <i class="bi bi-plus-circle"></i>
                                            Tambah Aset Inventaris
                                        </button>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <button class="btn btn-outline-success fw-bold rounded-5" wire:click='addAset'>
                                            <i class="bi bi-plus-circle"></i>
                                            Tambah Aset Inventaris
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        @elseif ($jenisInv == 'keluar')
            <div wire:loading.remove wire:target.except='dataAsetKeluar, search, toggleTextarea'>
                <div class="col-12 mb-3">
                    <label for="tahun" class="fw-bold">Tahun Pengurangan Inventaris</label>
                    <select name="tahun" id="tahun" class="form-select rounded-5">
                        <option value="" selected hidden>Pilih Tahun Pengurangan Inventaris</option>
                        @for ($i = 5; $i >= 0; $i--)
                            <option value="{{ date('Y') - $i }}">{{ date('Y') - $i }}</option>
                        @endfor
                    </select>
                    <hr class="mb-0">
                </div>
                <div class="col-12 mb-3">
                    <input type="text" class="form-control rounded-5" placeholder="Pencarian..."
                        wire:model.live='search'>
                </div>
                <div class="col-12 mb-3">
                    <table class="table table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th></th>
                                <th>Kode Aset</th>
                                <th>Nama Aset</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($aset as $itemAset)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td>
                                        {{ $itemAset->id_item }}
                                    </td>
                                    <td>
                                        {{ $itemAset->name }}
                                    </td>
                                    <td>
                                        <textarea cols="30" class="form-control form-control-sm" style='resize: none;' disabled></textarea>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <h3 class="text-center fw-bold">Data Aset Kosong</h3>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        @if ($jenisInv != null)
            <div class="col-12 d-grid gap-2">
                <button class="btn btn-outline-primary rounded-5 fw-bold">
                    Simpan
                </button>
            </div>
        @endif
    </div>
    <pre>
        {{ print_r($dataAsetKeluar) }}
    </pre>
</div>
