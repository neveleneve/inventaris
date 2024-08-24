@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h3 class="fw-bold h1">Report</h3>
                <hr>
            </div>
        </div>
        @livewire('report-index')
    </div>
@endsection
