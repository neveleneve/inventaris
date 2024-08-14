<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use Illuminate\Http\Request;

class InventarisController extends Controller {

    public function __construct() {
        $this->middleware('permission:inventaris index')->only('index');
        $this->middleware('permission:inventaris create')->only('create', 'store');
    }
    public function index() {
        // $data = Inventaris::get();
        // dd($data);
        return view('pages.inventaris.index');
    }

    public function create() {
        return view('pages.inventaris.create');
    }

    public function store(Request $request) {
        //
    }

    public function show(Inventaris $inventaris) {
        //
    }

    public function edit(Inventaris $inventaris) {
        //
    }

    public function update(Request $request, Inventaris $inventaris) {
        //
    }

    public function destroy(Inventaris $inventaris) {
        //
    }
}
