<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recetas;
use App\Models\Dificultades;
use App\Models\Plantas;
use Illuminate\Support\Facades\Validator;

class RecetasController extends Controller
{
    // Método para mostrar todas las recetas en JSON
    public function index()
    {
        $recetas = Recetas::with(['dificultad', 'planta'])->get();
        return response()->json($recetas, 200);
    }

    // Método para mostrar la vista de recetas en administración
    public function showRecipes()
{
    $recetas = Recetas::with(['dificultad', 'planta'])->get();
    $dificultades = Dificultades::all();
    $plantas = Plantas::all();

    return view('admin.recetas', compact('recetas', 'dificultades', 'plantas'));
}


    // Obtener detalles de una receta específica en JSON
    public function show($id)
    {
        $receta = Recetas::with(['dificultad', 'planta'])->find($id);

        if (!$receta) {
            return response()->json(['message' => 'Receta no encontrada'], 404);
        }

        return response()->json($receta);
    }

    // Método para crear una nueva receta
    public function create(Request $request)
{
    $valid = Validator::make($request->all(), [
        'nombre' => 'required|string|max:100',
        'ingredientes' => 'required|string',
        'preparacion' => 'required|string',
        'tiempo_preparacion' => 'nullable|integer',
        'dificultad_id' => 'required|exists:dificultades,id',
        'planta_id' => 'required|exists:plantas,id',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    if ($valid->fails()) {
        return redirect()->back()->withErrors($valid)->withInput();
    }

    $data = $request->all();

    // Guardar la foto si se carga
    if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
        $fotoArchivo = $request->file('foto');
        $nombreArchivo = time() . '-' . str_replace(' ', '_', $request->nombre) . '.' . $fotoArchivo->getClientOriginalExtension();
        $fotoArchivo->move(public_path('assets/img/recetas'), $nombreArchivo);
        $data['foto'] = $nombreArchivo;
    } else {
        $data['foto'] = '0.jpg';
    }

    Recetas::create($data);

    return redirect()->route('admin.recetas')->with('success', 'Receta agregada exitosamente');
}

public function update(Request $request, $id)
{
    $receta = Recetas::find($id);

    if (!$receta) {
        return redirect()->route('admin.recetas')->with('error', 'Receta no encontrada');
    }

    $valid = Validator::make($request->all(), [
        'nombre' => 'required|string|max:100',
        'ingredientes' => 'required|string',
        'preparacion' => 'required|string',
        'tiempo_preparacion' => 'nullable|integer',
        'dificultad_id' => 'required|exists:dificultades,id',
        'planta_id' => 'required|exists:plantas,id',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    if ($valid->fails()) {
        return redirect()->back()->withErrors($valid)->withInput();
    }

    $data = $request->all();

    if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
        $fotoArchivo = $request->file('foto');
        $nombreArchivo = time() . '-' . str_replace(' ', '_', $request->nombre) . '.' . $fotoArchivo->getClientOriginalExtension();
        $fotoArchivo->move(public_path('assets/img/recetas'), $nombreArchivo);
        $data['foto'] = $nombreArchivo;
    } else {
        $data['foto'] = $receta->foto;
    }

    $receta->update($data);

    return redirect()->route('admin.recetas')->with('success', 'Receta actualizada exitosamente');
}


    // Método para actualizar una receta


    // Método para eliminar una receta
    public function delete($id)
    {
        $receta = Recetas::find($id);

        if (!$receta) {
            return redirect()->route('admin.recetas')->with('error', 'Receta no encontrada');
        }

        $receta->delete();

        return redirect()->route('admin.recetas')->with('success', 'Receta eliminada exitosamente');
    }

    // Método para buscar recetas
    public function search(Request $request)
    {
        $query = $request->input('query', '');

        $recetas = Recetas::where('nombre', 'LIKE', "%{$query}%")
            ->with(['dificultad', 'planta'])
            ->get();

        return response()->json($recetas);
    }

    // Método para obtener los datos de una receta específica para editar
    public function edit($id)
{
    $receta = Recetas::with(['dificultad', 'planta'])->find($id);

    if (!$receta) {
        return response()->json(['message' => 'Receta no encontrada'], 404);
    }

    // Cargar todas las dificultades y plantas para el modal de edición
    $dificultades = Dificultades::all();
    $plantas = Plantas::all();

    return response()->json([
        'receta' => $receta,
        'dificultades' => $dificultades,
        'plantas' => $plantas
    ]);
}


}
