@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h3 class="fw-bold h1">Dashboard</h3>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 text-bg-primary rounded-3">
                                    <i class="fa fa-check fa-lg fa-fw"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-4">
                                <p class="text-muted mb-1 fw-bold">Aset Tersedia</p>
                                <h2 class="mb-0">
                                    {{ $asetok }}
                                    <span style="font-size: 0.875rem">
                                        Unit</span>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 text-bg-danger rounded-3">
                                    <i class="fa fa-times fa-lg fa-fw"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-4">
                                <p class="text-muted mb-1 fw-bold">Aset Tidak Tersedia</p>
                                <h2 class="mb-0">
                                    {{ $asetnok }}
                                    <span style="font-size: 0.875rem">
                                        Unit</span>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Grafik Status Aset Masuk</h5>
                        <canvas id="chartAsetMasuk"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Grafik Status Aset Keluar</h5>
                        <canvas id="chartAsetKeluar"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('customjs')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartAsetMasuk = document.getElementById('chartAsetMasuk').getContext('2d');
            const chartAsetKeluar = document.getElementById('chartAsetKeluar').getContext('2d');
            new Chart(chartAsetMasuk, {
                type: 'line',
                data: {
                    labels: [
                        '{{ now()->subYears(4)->year }}',
                        '{{ now()->subYears(3)->year }}',
                        '{{ now()->subYears(2)->year }}',
                        '{{ now()->subYear()->year }}',
                        '{{ now()->year }}'
                    ],
                    datasets: [
                        @foreach ($kategori as $jenis)
                            {
                                label: '{{ $jenis->name }}',
                                data: [
                                    {{ isset($asetMasukPerJenis[$jenis->id][now()->subYears(4)->year]) ? $asetMasukPerJenis[$jenis->id][now()->subYears(4)->year] : 0 }},
                                    {{ isset($asetMasukPerJenis[$jenis->id][now()->subYears(3)->year]) ? $asetMasukPerJenis[$jenis->id][now()->subYears(3)->year] : 0 }},
                                    {{ isset($asetMasukPerJenis[$jenis->id][now()->subYears(2)->year]) ? $asetMasukPerJenis[$jenis->id][now()->subYears(2)->year] : 0 }},
                                    {{ isset($asetMasukPerJenis[$jenis->id][now()->subYear()->year]) ? $asetMasukPerJenis[$jenis->id][now()->subYear()->year] : 0 }},
                                    {{ isset($asetMasukPerJenis[$jenis->id][now()->year]) ? $asetMasukPerJenis[$jenis->id][now()->year] : 0 }}
                                ],
                                @php
                                    $color = 'rgb(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ')';
                                @endphp
                                borderColor: '{{ $color }}',
                                backgroundColor: '{{ $color }}',
                                tension: 0,
                                fill: false
                            },
                        @endforeach
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
            new Chart(chartAsetKeluar, {
                type: 'line',
                data: {
                    labels: [
                        '{{ now()->subYears(4)->year }}',
                        '{{ now()->subYears(3)->year }}',
                        '{{ now()->subYears(2)->year }}',
                        '{{ now()->subYear()->year }}',
                        '{{ now()->year }}'
                    ],
                    datasets: [
                        @foreach ($kategori as $jenis)
                            {
                                label: '{{ $jenis->name }}',
                                data: [
                                    {{ isset($asetKeluarPerJenis[$jenis->id][now()->subYears(4)->year]) ? $asetKeluarPerJenis[$jenis->id][now()->subYears(4)->year] : 0 }},
                                    {{ isset($asetKeluarPerJenis[$jenis->id][now()->subYears(3)->year]) ? $asetKeluarPerJenis[$jenis->id][now()->subYears(3)->year] : 0 }},
                                    {{ isset($asetKeluarPerJenis[$jenis->id][now()->subYears(2)->year]) ? $asetKeluarPerJenis[$jenis->id][now()->subYears(2)->year] : 0 }},
                                    {{ isset($asetKeluarPerJenis[$jenis->id][now()->subYear()->year]) ? $asetKeluarPerJenis[$jenis->id][now()->subYear()->year] : 0 }},
                                    {{ isset($asetKeluarPerJenis[$jenis->id][now()->year]) ? $asetKeluarPerJenis[$jenis->id][now()->year] : 0 }}
                                ],
                                @php
                                    $color = 'rgb(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ')';
                                @endphp
                                borderColor: '{{ $color }}',
                                backgroundColor: '{{ $color }}',
                                tension: 0,
                                fill: false
                            },
                        @endforeach
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
@endpush
