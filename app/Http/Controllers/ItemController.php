<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ItemController extends Controller {
    public function __construct() {
        $this->middleware('permission:aset index')->only('index');
        $this->middleware('permission:aset show')->only('show');
        $this->middleware('permission:aset edit')->only('edit', 'update');
    }

    public function index() {
        return view('pages.item.index');
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        $validasi = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'jenis' => ['required', 'numeric'],
        ]);

        if ($validasi->fails()) {
            Alert::error('Kesalahan', 'Data Kurang Lengkap');
            return redirect(route('item.index'));
        } else {
            $string = $this->randomString();
            $store = Item::create([
                'name' => $request->name,
                'jenis_id' => $request->jenis,
                'id_item' => $string,
            ]);
            if ($store) {
                Alert::success('Berhasil', 'Data berhasil ditambah dengan ID Item ' . $string . '!');
                return redirect(route('item.index'));
            } else {
                Alert::error('Gagal', 'Data gagal ditambah!');
                return redirect(route('item.index'));
            }
        }
    }

    public function show(Item $item) {
        //
    }

    public function edit(Item $item) {
        //
    }

    public function update(Request $request, Item $item) {
        //
    }

    public function destroy(Item $item) {
        //
    }

    function randomString($length = 10) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkalmnopqrstuvwxyz';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $randomIndex = rand(0, strlen($characters) - 1);
            $string .= $characters[$randomIndex];
        }
        return $string;
    }
}
