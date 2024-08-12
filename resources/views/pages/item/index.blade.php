@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h3 class="fw-bold h1">Aset</h3>
                <hr>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            @livewire('aset-index')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
