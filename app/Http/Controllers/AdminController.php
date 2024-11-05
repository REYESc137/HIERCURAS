<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');  // Esta es la vista para los administradores
    }

    public function plantas()
    {
        return view('admin.plantas');
    }

    public function descubridores()
    {
        return view('admin.descubridores');
    }

    public function usuarios()
    {
        return view('admin.usuarios');
    }

    public function recetas()
    {
        return view('admin.recetas');
    }
}
