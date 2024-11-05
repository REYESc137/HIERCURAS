<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Familia;
use Illuminate\Support\Facades\Validator;

class FamiliaController extends Controller
{
    /**
     * Listar todas las familias.
     */
    public function index()
    {
        $familias = Familia::all();

        if ($familias->isEmpty()) {
            return response()->json(['message' => 'Sin familias registradas'], 200);
        }

        return response()->json($familias, 200);
    }

    /**
     * Crear una nueva familia.
     */
    public function create(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100'
        ]);

        if ($valid->fails()) {
            return response()->json([
                'message' => 'Dato(s) inválidos',
                'errors' => $valid->errors(),
                'status' => 400
            ]);
        }

        $familia = Familia::create([
            'nombre' => $request->nombre
        ]);

        return response()->json(['familia' => $familia, 'status' => 201]);
    }

    /**
     * Actualizar una familia existente.
     */
    public function update(Request $request, $id)
    {
        $familia = Familia::find($id);

        if (!$familia) {
            return response()->json(['message' => 'Familia no encontrada', 'status' => 404], 404);
        }

        $valid = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100'
        ]);

        if ($valid->fails()) {
            return response()->json([
                'message' => 'Dato(s) inválidos',
                'errors' => $valid->errors(),
                'status' => 400
            ]);
        }

        $familia->nombre = $request->nombre;
        $familia->save();

        return response()->json(['message' => 'Familia actualizada', 'familia' => $familia], 200);
    }

    /**
     * Eliminar una familia.
     */
    public function delete($id)
    {
        $familia = Familia::find($id);

        if (!$familia) {
            return response()->json(['message' => 'Familia no encontrada', 'status' => 404], 404);
        }

        $familia->delete();

        return response()->json(['message' => 'Familia eliminada', 'status' => 200]);
    }
}
