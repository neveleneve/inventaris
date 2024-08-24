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
    </div>
@endsection
