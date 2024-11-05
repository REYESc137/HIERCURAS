<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EspRelac;
use Illuminate\Support\Facades\Validator;

class EspRelacController extends Controller
{
    /**
     * Listar todas las especies relacionadas.
     */
    public function index()
    {
        $especies = EspRelac::all();

        if ($especies->isEmpty()) {
            return response()->json(['message' => 'Sin especies relacionadas registradas'], 200);
        }

        return response()->json($especies, 200);
    }

    /**
     * Crear una nueva especie relacionada.
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

        $especie = EspRelac::create([
            'nombre' => $request->nombre
        ]);

        return response()->json(['especie' => $especie, 'status' => 201]);
    }

    /**
     * Actualizar una especie relacionada existente.
     */
    public function update(Request $request, $id)
    {
        $especie = EspRelac::find($id);

        if (!$especie) {
            return response()->json(['message' => 'Especie no encontrada', 'status' => 404], 404);
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

        $especie->nombre = $request->nombre;
        $especie->save();

        return response()->json(['message' => 'Especie actualizada', 'especie' => $especie], 200);
    }

    /**
     * Eliminar una especie relacionada.
     */
    public function delete($id)
    {
        $especie = EspRelac::find($id);

        if (!$especie) {
            return response()->json(['message' => 'Especie no encontrada', 'status' => 404], 404);
        }

        $especie->delete();

        return response()->json(['message' => 'Especie eliminada', 'status' => 200]);
    }
}
