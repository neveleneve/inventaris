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
                        <div class="row justify-content-center">
                            <div class="col-12 mb-3">
                                <label for="jenis" class="fw-bold">Jenis Inventarisasi</label>
                                <select name="jenis" id="jenis" class="form-select">
                                    <option value="" selected hidden>Pilih Jenis Inventarisasi</option>
                                    <option value="masuk">Masuk / Penambahan</option>
                                    <option value="keluar">Keluar / Pengurangan</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="tahun" class="fw-bold">Tahun Pengadaan</label>
                                <select name="jenis" id="jenis" class="form-select">
                                    <option value="" selected hidden>Pilih Tahun Pengadaan</option>
                                    @for ($i = 5; $i >= 0; $i--)
                                        <option value="{{ date('Y') - $i }}">{{ date('Y') - $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
