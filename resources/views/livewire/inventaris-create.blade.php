<div>
    <div class="row justify-content-center">
        <div class="col-lg-12 justify-content-center" wire:loading wire:loading.class='d-flex'
            wire:target.except='tahun, addAset, dataAsetTambah,deleteAset, search, dataAsetTerpilih, tempSelectedDataAset, tempSelectedDataAsetTerpilih, selectDataAset, selectDataAsetTerpilih, addAsetTerpilih, deleteAsetTerpilih'>
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div class="col-12 mb-3">
            <label for="jenis" class="fw-bold">Jenis Inventarisasi</label>
            <select name="jenis" id="jenis" class="form-select rounded-5" wire:model.live='jenisInv'>
                <option value="" selected hidden>Pilih Jenis Inventarisasi</option>
                <option value="masuk">Masuk / Penambahan</option>
                <option value="keluar">Keluar / Pengurangan</option>
            </select>
        </div>
        @if ($jenisInv == 'masuk')
            <div wire:loading.remove wire:target='jenisInv' wire:target.except='addAset, tahun, dataAsetTambah, save'>
                <div class="col-12 mb-3">
                    <label for="tahun" class="fw-bold">Tahun Pengadaan Inventaris</label>
                    <select name="tahun" id="tahun" class="form-select rounded-5" wire:model.live='tahun'>
                        <option value="" selected hidden>Pilih Tahun Pengadaan Inventaris</option>
                        @for ($i = 5; $i >= 0; $i--)
                            <option value="{{ date('Y') - $i }}">{{ date('Y') - $i }}</option>
                        @endfor
                    </select>
                    @error('tahun')
                        <span class="text-danger">*</span> <span class="fw-bold">{{ $message }}</span>
                    @enderror
                    <hr class="mb-0">
                </div>
                <div class="col-12 mb-3">
                    <div>
                        @error('dataAsetTambah')
                            <span class="text-danger">*</span>
                            <span class="fw-bold">{{ $message }}</span>
                        @enderror
                    </div>
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
                                @for ($i = 0; $i < count($dataAsetTambah); $i++)
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
                                                wire:model.live='dataAsetTambah.{{ $i }}.nama'>
                                            @error('dataAsetTambah.*.nama')
                                                <span class="text-danger">*</span>
                                                <span class="fw-bold">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td>
                                            <select name="jenisaset[]" id="jenisaset{{ $i }}"
                                                class="form-select"
                                                wire:model.live='dataAsetTambah.{{ $i }}.jenis'>
                                                <option value="">Pilih Jenis Aset</option>
                                                @foreach ($jenisAset as $jenis)
                                                    <option value="{{ $jenis->id }}">{{ $jenis->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('dataAsetTambah.*.jenis')
                                                <span class="text-danger">*</span>
                                                <span class="fw-bold">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="number" class="form-control"
                                                id="totalaset{{ $i }}" name="totalaset[]"
                                                placeholder="Total Aset"
                                                wire:model.live='dataAsetTambah.{{ $i }}.total'>
                                            @error('dataAsetTambah.*.total')
                                                <span class="text-danger">*</span>
                                                <span class="fw-bold">{{ $message }}</span>
                                            @enderror
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
            {{-- <pre>
                {{ print_r($dataAsetTambah) }}
            </pre> --}}
        @elseif ($jenisInv == 'keluar')
            <div wire:loading.remove
                wire:target.except='save, search, dataAsetTerpilih, tempSelectedDataAset, tempSelectedDataAsetTerpilih, selectDataAset, selectDataAsetTerpilih, addAsetTerpilih, deleteAsetTerpilih'>
                <div class="col-12 mb-3">
                    <label for="tahun" class="fw-bold">Tahun Pengurangan Inventaris</label>
                    <select name="tahun" id="tahun" class="form-select rounded-5" wire:model.live='tahun'>
                        <option value="" selected hidden>Pilih Tahun Pengurangan Inventaris</option>
                        @for ($i = 5; $i >= 0; $i--)
                            <option value="{{ date('Y') - $i }}">{{ date('Y') - $i }}</option>
                        @endfor
                    </select>
                    @error('tahun')
                        <span class="text-danger">*</span> <span class="fw-bold">{{ $message }}</span>
                    @enderror
                    <hr class="mb-0">
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 col-xxl">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <input type="text" class="form-control rounded-5" placeholder="Pencarian..."
                                    wire:model.live='search'>
                            </div>
                        </div>
                        <h3 class="fw-bold">Data Aset</h3>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered text-nowrap">
                                <thead class="table-dark">
                                    <tr>
                                        <th></th>
                                        <th>Kode Aset</th>
                                        <th>Nama Aset</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($dataAset as $itemAset)
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        wire:model.live='selectDataAset'
                                                        value="{{ $itemAset['id'] }}">
                                                </div>
                                            </td>
                                            <td>
                                                {{ $itemAset['id_item'] }}
                                            </td>
                                            <td>
                                                {{ $itemAset['name'] }}
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
                    <div class="col col-xxl-1 align-item-center">
                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <button class="btn btn-sm btn-outline-warning" type="button"
                                    wire:click='addAsetTerpilih'
                                    {{ count($tempSelectedDataAset) <= 0 ? 'disabled' : null }}>
                                    <i class="bi bi-chevron-right d-none d-xxl-block"></i>
                                    <i class="bi bi-chevron-down d-xxl-none"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <button class="btn btn-sm btn-outline-warning" type="button"
                                    wire:click='deleteAsetTerpilih'
                                    {{ count($tempSelectedDataAsetTerpilih) <= 0 ? 'disabled' : null }}>
                                    <i class="bi bi-chevron-left d-none d-xxl-block"></i>
                                    <i class="bi bi-chevron-up d-xxl-none"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xxl">
                        <h3 class="fw-bold">Data Aset Dipilih</h3>
                        @error('dataAsetTerpilih')
                            <span class="text-danger">*</span> <span class="fw-bold">{{ $message }}</span>
                        @enderror
                        @error('dataAsetTerpilih.*.keterangan')
                            <span class="text-danger">*</span>
                            <span class="fw-bold text-wrap">{{ $message }}</span>
                        @enderror
                        <table class="table table-bordered table-hover text-nowrap">
                            <thead class="table-dark">
                                <tr>
                                    <th></th>
                                    <th>Kode Aset</th>
                                    <th>Nama Aset</th>
                                    <th>Keterangan <span title="Harus diisi" class="text-danger">*</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataAsetTerpilih as $itemTerpilih)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    wire:model.live='selectDataAsetTerpilih'
                                                    value="{{ $itemTerpilih['id'] }}">
                                            </div>
                                        </td>
                                        <td>
                                            {{ $itemTerpilih['id_item'] }}
                                        </td>
                                        <td>
                                            {{ $itemTerpilih['name'] }}
                                        </td>
                                        <td>
                                            <textarea wire:model.live='dataAsetTerpilih.{{ $loop->index }}.keterangan' class="form-control"></textarea>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">
                                            <h3 class="text-center fw-bold">Data Kosong</h3>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- <pre>
                {{ print_r($dataAsetTerpilih) }}
            </pre> --}}
        @endif
        @if ($jenisInv != null)
            <div class="col-12 d-grid gap-2">
                <button class="btn btn-outline-primary rounded-5 fw-bold" wire:click='save'>
                    Simpan
                </button>
            </div>
        @endif
    </div>
</div>

@push('customjs')
    <script>
        Livewire.on('alert', (event) => {
            Swal.fire({
                title: event.data.title,
                text: event.data.text,
                icon: event.data.icon
            })
        });
    </script>
@endpush
