@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h3 class="fw-bold h1">Tambah Data Inventarisasi</h3>
                <hr>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @livewire('inventaris-create')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
