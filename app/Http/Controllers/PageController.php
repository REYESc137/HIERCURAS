<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function plantasMedicinales() {
        return view('plantas-medicinales');
    }

    public function descubridores() {
        return view('descubridores');
    }

    public function metodosElaboracion() {
        return view('metodos-elaboracion');
    }
}
