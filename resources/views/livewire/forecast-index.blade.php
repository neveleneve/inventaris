<div>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3 row">
                <label for="cate" class="col-md-4 col-form-label fw-bold">Jenis Aset</label>
                <div class="col-md-8">
                    <select id="cate" wire:model.live='choosenCategory' class="form-select">
                        @foreach ($category as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3 row">
                <label for="total_data" class="col-md-4 col-form-label fw-bold">Total Data</label>
                <div class="col-md-8">
                    <select id="total_data" wire:model.live='dataTotal' class="form-select">
                        <option value="3">3 Data</option>
                        <option value="5">5 Data</option>
                        <option value="10">10 Data</option>
                        <option value="15">15 Data</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3 row">
                <label for="interval" class="col-md-4 col-form-label fw-bold">Interval</label>
                <div class="col-md-8">
                    <select id="interval" wire:model.live='period' class="form-select">
                        <option value="3">3 Tahun</option>
                        @if ($dataTotal >= 5)
                            <option value="5">5 Tahun</option>
                        @endif
                        @if ($dataTotal >= 10)
                            <option value="10">10 Tahun</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3 row">
                <label for="metode" class="col-md-4 col-form-label fw-bold">Metode</label>
                <div class="col-md-8">
                    <select id="metode" wire:model.live='methodType' class="form-select">
                        <option value="sma">Simple Moving Average</option>
                        <option value="ema">Exponential Moving Average</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="mb-3 row">
                <label for="tipe_inventaris" class="col-md-4 col-form-label fw-bold">Tipe Inventarisasi</label>
                <div class="col-md-8">
                    <select id="tipe_inventaris" wire:model.live='inventType' class="form-select">
                        <option value="masuk">Masuk</option>
                        <option value="keluar">Keluar</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="mb-3 row">
                <label for="tampilan" class="col-md-4 col-form-label fw-bold">Tampilan</label>
                <div class="col-md-8">
                    <select id="tampilan" wire:model.live='graph' class="form-select">
                        <option value="1">Grafik</option>
                        <option value="0">Table</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-12 mt-3">
            <h1 class="fw-bold text-dark h3">
                Data Peramalan Aset {{ ucfirst($inventType) }} ({{ $cat_name }})
            </h1>
            <div class="row">
                <div class="col-lg-12 justify-content-center mt-3" wire:loading wire:loading.class='d-flex'>
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            {{-- <div> --}}
            <canvas wire:loading.remove class="{{ !$graph ? 'd-none' : '' }} mt-3" id="chartForecast"></canvas>
            {{-- </div> --}}
            <div wire:loading.remove class="row {{ $graph ? 'd-none' : '' }} mt-3">
                <div class="col-12">
                    <table class="table table-bordered">
                        <thead class="table-dark text-center">
                            <tr>
                                <th class="align-middle">Tahun</th>
                                <th class="align-middle">Data Aktual</th>
                                <th class="align-middle">Data Peramalan</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item['tahun'] }}</td>
                                    <td>{{ $item['actual'] }}</td>
                                    <td>{{ $item['forecast'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@push('customjs')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script>
        let myChart = null; // Change to let and initialize as null

        function updateChart(newData) {
            if (myChart) {
                myChart.destroy();
            }

            if (!newData || !newData.labels) {
                console.error('Invalid chart data:', newData);
                return;
            }

            const ctx = document.getElementById('chartForecast').getContext('2d');
            myChart = new Chart(ctx, {
                type: 'bar',
                data: newData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const initialData = @json($chartData);
            if (initialData && initialData.labels) {
                updateChart(initialData);
            }
        });

        document.addEventListener("livewire:initialized", () => {
            Livewire.on('chartUpdated', (event) => {
                if (event.chartData && event.chartData.labels) {
                    updateChart(event.chartData);
                }
            });
        });
    </script>
@endpush
