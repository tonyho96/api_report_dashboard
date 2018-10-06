<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PdfController extends Controller
{
    public function index()
    {
        $pdf = PDF::loadView('dashboard.pdfs.template1')->setPaper('a4');
        return $pdf->stream();
    }
}
