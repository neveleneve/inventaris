<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller {
    public function __construct() {
        $this->middleware('permission:report index')->only('index');
    }

    public function index() {
        return view('pages.report.index');
    }
}
