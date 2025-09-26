<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
class ReportController extends Controller{
    public function index()
    {
        return view('reports.index');
    }
}