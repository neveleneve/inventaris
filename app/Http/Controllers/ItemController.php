<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ItemController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $item = Item::get();
        return view('pages.item.index', [
            'items' => $item
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(Item $item) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
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
