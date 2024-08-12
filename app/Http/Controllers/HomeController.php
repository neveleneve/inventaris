<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller {
    public function __construct() {
        $this->middleware('permission:dashboard')->only('index');
    }

    public function index() {
        return view('home');
    }
}
