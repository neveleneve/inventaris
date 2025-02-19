<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Status Aset Masuk</h5>
                <select id="asetMasuk" wire:model.live='graphMasuk' class="form-select">
                    <option value="1">Grafik</option>
                    <option value="0">Tabel</option>
                </select>
                <div class="col-lg-12 justify-content-center mt-3" wire:loading wire:loading.class='d-flex'
                    wire:target='graphMasuk'>
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <canvas wire:target='graphMasuk' wire:loading.remove class="{{ !$graphMasuk ? 'd-none' : '' }} mt-3"
                    id="chartAsetMasuk"></canvas>
                <div wire:target='graphMasuk' wire:loading.remove class="row {{ $graphMasuk ? 'd-none' : '' }} mt-3">
                    <div class="col-12">
                        <table class="table table-bordered">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th rowspan="2" class="align-middle">Tahun</th>
                                    <th colspan="{{ count($kategori) }}">Kategori</th>
                                </tr>
                                <tr>
                                    @foreach ($kategori as $cat)
                                        <th>{{ $cat->name }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($asetMasukPerJenisTable as $ampjt)
                                    <tr>
                                        <td>{{ $ampjt['tahun'] }}</td>
                                        @foreach ($ampjt['data'] as $data)
                                            <td class="col-md-2">{{ $data }} Item</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Status Aset Keluar</h5>
                <select wire:model.live='graphKeluar' class="form-select">
                    <option value="1">Grafik</option>
                    <option value="0">Tabel</option>
                </select>
                <div class="col-lg-12 justify-content-center mt-3" wire:loading wire:loading.class='d-flex'
                    wire:target='graphKeluar'>
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <canvas wire:target='graphKeluar' wire:loading.remove class="{{ !$graphKeluar ? 'd-none' : '' }} mt-3"
                    id="chartAsetKeluar"></canvas>
                <div wire:target='graphKeluar' wire:loading.remove class="row {{ $graphKeluar ? 'd-none' : '' }} mt-3">
                    <div class="col-12">
                        <table class="table table-bordered">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th rowspan="2" class="align-middle">Tahun</th>
                                    <th colspan="{{ count($kategori) }}">Kategori</th>
                                </tr>
                                <tr>
                                    @foreach ($kategori as $cat)
                                        <th>{{ $cat->name }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($asetKeluarPerJenisTable as $akpjt)
                                    <tr>
                                        <td>{{ $akpjt['tahun'] }}</td>
                                        @foreach ($akpjt['data'] as $data)
                                            <td class="col-md-2">{{ $data }} Item</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
