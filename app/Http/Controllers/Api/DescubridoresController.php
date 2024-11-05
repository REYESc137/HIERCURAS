<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Descubridores;
use Illuminate\Support\Facades\Validator;
use App\Models\Pais;

class DescubridoresController extends Controller
{
    // Método para mostrar descubridores en la vista de administración
    public function showDiscoverers()
    {
        $descubridores = Descubridores::with('pais')->get();
        $paises = Pais::all();
        return view('admin.descubridores', compact('descubridores', 'paises'));
    }

    // Obtener todos los descubridores en JSON
    public function index()
    {
        $descubridores = Descubridores::with('pais')->get();
        return response()->json($descubridores, 200);
    }

    // Obtener detalles de un descubridor específico en JSON
    // Obtener detalles de un descubridor específico en JSON
    public function show($id)
{
    $descubridor = Descubridores::with('pais')->find($id);

    if (!$descubridor) {
        return response()->json(['message' => 'Descubridor no encontrado'], 404);
    }

    return response()->json($descubridor);
}

public function edit($id)
{
    $descubridor = Descubridores::with('pais')->find($id);
    $paises = Pais::all();

    if (!$descubridor) {
        return response()->json(['message' => 'Descubridor no encontrado'], 404);
    }

    return response()->json([
        'descubridor' => $descubridor,
        'paises' => $paises
    ]);
}




    // Método para crear un descubridor
    public function create(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'pais_id' => 'nullable|exists:pais,id',
            'lugar_nacimiento' => 'nullable|string|max:255',
            'expediciones' => 'nullable|string',
            'biografia' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $data = $request->all();

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $fotoArchivo = $request->file('foto');
            $fotoExtension = $fotoArchivo->getClientOriginalExtension();
            $nombreArchivo = time() . '-' . $data['nombre'] . '.' . $fotoExtension;
            $fotoArchivo->move(public_path('assets/img/descubridores'), $nombreArchivo);
            $data['foto'] = $nombreArchivo;
        } else {
            $data['foto'] = '0.jpg';
        }

        Descubridores::create($data);

        return redirect()->route('admin.descubridores')->with('success', 'Descubridor agregado exitosamente');
    }

    // Método para buscar descubridores
    public function search(Request $request)
    {
        $query = $request->input('query', '');

        $descubridores = Descubridores::where('nombre', 'LIKE', "%{$query}%")
            ->with('pais')
            ->get();

        return response()->json($descubridores);
    }

    // Método para actualizar un descubridor
    public function update(Request $request, $id)
    {
        $descubridor = Descubridores::find($id);

        if (!$descubridor) {
            return response()->json(['message' => 'Descubridor no encontrado'], 404);
        }

        $valid = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'pais_id' => 'nullable|exists:pais,id',
            'lugar_nacimiento' => 'nullable|string|max:255',
            'expediciones' => 'nullable|string',
            'biografia' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $data = $request->all();

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $fotoArchivo = $request->file('foto');
            $fotoExtension = $fotoArchivo->getClientOriginalExtension();
            $nombreArchivo = time() . '-' . $data['nombre'] . '.' . $fotoExtension;
            $fotoArchivo->move(public_path('assets/img/descubridores'), $nombreArchivo);
            $data['foto'] = $nombreArchivo;
        } else {
            $data['foto'] = $descubridor->foto;
        }

        $descubridor->update($data);

        return redirect()->route('admin.descubridores')->with('success', 'Descubridor actualizado exitosamente');
    }

    // Método para eliminar un descubridor

    public function delete($id)
    {
        $descubridor = Descubridores::find($id);

        if (!$descubridor) {
            return response()->json(['message' => 'Descubridor no encontrado'], 404);
        }

        $descubridor->delete();

        return redirect()->route('admin.descubridores')->with('success', 'Descubridor actualizado exitosamente');
    }
}
