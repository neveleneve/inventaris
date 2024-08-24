<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="row" method="GET" wire:submit='cetak' target="__blank">
                    <div class="col-12 mb-3">
                        <label for="jenis" class="fw-bold">Jenis Laporan</label>
                        <select name="jenis" id="jenis" class="form-select rounded-5"
                            wire:model.live='jenisReport'>
                            <option value="" selected hidden>Pilih Jenis Report</option>
                            <option value="tahunan">Inventarisasi Tahunan</option>
                            <option value="aset_tersedia">Aset Tersedia</option>
                            <option value="aset_masuk">Aset Masuk</option>
                            <option value="aset_keluar">Aset Keluar</option>
                        </select>
                    </div>
                    @if ($jenisReport == 'tahunan')
                        <div class="col-12 mb-3">
                            <label for="tahun" class="fw-bold">Tahun Anggaran / Pencatatan</label>
                            <select id="tahun" class="form-select rounded-5" wire:model.live='tahun'>
                                <option value="" selected hidden>Pilih Tahun Anggaran / Pencatatan</option>
                                @for ($i = 5; $i >= 0; $i--)
                                    <option value="{{ date('Y') - $i }}">
                                        {{ date('Y') - $i }}
                                    </option>
                                @endfor
                            </select>
                            @error('tahun')
                                <span class="text-danger">*</span> <span class="fw-bold">{{ $message }}</span>
                            @enderror
                        </div>
                    @elseif ($jenisReport == 'aset_masuk')
                        <div class="col-12 mb-3">
                            <label for="tahunMasuk" class="fw-bold">Tahun Anggaran / Pencatatan</label>
                            <select id="tahunMasuk" class="form-select rounded-5" wire:model.live='tahunMasuk'>
                                <option value="" selected hidden>Pilih Tahun Anggaran / Pencatatan</option>
                                <option value="all">Semua</option>
                                @for ($i = 5; $i >= 0; $i--)
                                    <option value="{{ date('Y') - $i }}">
                                        {{ date('Y') - $i }}
                                    </option>
                                @endfor
                            </select>
                            @error('tahunMasuk')
                                <span class="text-danger">*</span> <span class="fw-bold">{{ $message }}</span>
                            @enderror
                        </div>
                    @elseif ($jenisReport == 'aset_keluar')
                        <div class="col-12 mb-3">
                            <label for="tahunKeluar" class="fw-bold">Tahun Anggaran / Pencatatan</label>
                            <select id="tahunKeluar" class="form-select rounded-5" wire:model.live='tahunKeluar'>
                                <option value="" selected hidden>Pilih Tahun Anggaran / Pencatatan</option>
                                <option value="all">Semua</option>
                                @for ($i = 5; $i >= 0; $i--)
                                    <option value="{{ date('Y') - $i }}">
                                        {{ date('Y') - $i }}
                                    </option>
                                @endfor
                            </select>
                            @error('tahunKeluar')
                                <span class="text-danger">*</span> <span class="fw-bold">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                    @if ($jenisReport != '')
                        <div class="col-12 d-grid gap-2">
                            <button class="btn btn-outline-primary rounded-5 fw-bold" type="submit">
                                Cetak
                            </button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
    @push('customjs')
        <script>
            Livewire.on('open-report', event => {
                // event.preventDefault(); // Prevent the default submission behavior
                window.open(event.route, '_blank'); // Open the new tab with the desired URL
            });
        </script>
    @endpush
</div>
