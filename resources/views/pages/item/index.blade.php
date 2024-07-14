@extends('layouts.app')

@section('content')
    <div class="container">
        @include('layouts.navigation')
        <div class="row justify-content-center">
            <div class="col-lg-8 d-grid gap-2 mb-3">
                <button class="btn btn-sm btn-outline-dark fw-bold rounded-5" data-bs-toggle="modal"
                    data-bs-target="#modalAdd">
                    Tambah
                </button>
                <input type="text" class="form-control form-control-sm rounded-5" placeholder="Pencarian...">
                <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Tambah Item</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('item.store') }}" method="post">
                                <div class="modal-body">
                                    @csrf
                                    <label for="name" class="fw-bold">Nama Item</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control form-control-sm rounded-5 mb-3">
                                    <label for="jenis" class="fw-bold">Jenis Item</label>
                                    <select name="jenis" id="jenis" class="form-select form-select-sm rounded-5 mb-3">
                                        <option selected hidden>Pilih Jenis Item</option>
                                        <option value="1">Barang Tidak Bergerak</option>
                                        <option value="2">Barang Bergerak</option>
                                        <option value="3">Barang Habis Pakai</option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-outline-danger fw-bold rounded-5"
                                        data-bs-dismiss="modal">
                                        Batal
                                    </button>
                                    <button type="submit" class="btn btn-sm btn-outline-dark fw-bold rounded-5">
                                        Tambah
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <table class="table table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Qty</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                            <tr>
                                <td>{{ $item->id_item }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>
                                    <a href="{{ route('item.edit', ['item' => $item->id]) }}"
                                        class="btn btn-sm btn-outline-warning rounded-5 fw-bold">
                                        Edit
                                    </a>
                                    <a href="{{ route('item.edit', ['item' => $item->id]) }}"
                                        class="btn btn-sm btn-outline-danger rounded-5 fw-bold">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <h2 class="text-center fw-bold">Data Kosong</h2>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
