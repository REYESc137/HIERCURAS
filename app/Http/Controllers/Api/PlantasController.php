<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plantas;
use App\Models\Familia;
use App\Models\Descubridores;
use App\Models\EspRelac;
use App\Models\Pais;
use Illuminate\Support\Facades\Validator;

class PlantasController extends Controller
{
    // Método para mostrar plantas en la vista de administración




    // Obtener todos las plantas en JSON
    public function index()
{
    $plantas = Plantas::with(['familia', 'descubridor', 'especiesRelacionadas', 'lugarOrigen'])->get();

    dd($plantas->toArray()); // Aquí debería mostrar la información completa, incluyendo `lugarOrigen` con el nombre
    if ($plantas->isEmpty()) {
        return response()->json(['message' => 'Sin plantas registradas'], 200);
    }

    return response()->json($plantas, 200);
}



public function showPlants()
{
    // Incluye `with()` en la consulta para cargar todas las relaciones necesarias
    $plantas = Plantas::with(['familia', 'descubridor', 'especiesRelacionadas', 'lugarOrigen'])->get();

    // Conversión explícita para asegurarnos que `lugarOrigen` esté en el formato correcto.
    $plantas = $plantas->map(function($planta) {
        return [
            'id' => $planta->id,
            'nombre_comun' => $planta->nombre_comun,
            'familia' => $planta->familia ? $planta->familia->nombre : 'Sin familia',
            'lugar_origen' => $planta->lugarOrigen ? $planta->lugarOrigen->nombre : 'Sin lugar de origen definido',
            // otros atributos
        ];
    });
    // Verificar que cada planta tenga cargada la relación `lugarOrigen`
    // foreach ($plantas as $planta) {
    //     if (!$planta->relationLoaded('lugarOrigen')) {
    //         $planta->load('lugarOrigen');
    //     }
    // }

    // // dd() para inspeccionar la estructura y asegurarse de que `lugarOrigen` esté como un objeto completo
    // // dd($plantas->toArray());

    $familias = Familia::all();
    $descubridores = Descubridores::all();
    $paises = Pais::all();
    $especiesRelacionadas = EspRelac::all();

    return view('admin.plantas', compact('plantas', 'familias', 'descubridores', 'paises', 'especiesRelacionadas'));
}



public function show($id)
{
    $planta = Plantas::with(['familia', 'descubridor', 'especiesRelacionadas', 'lugarOrigen'])->find($id);

    if (!$planta) {
        return response()->json(['message' => 'Planta no encontrada'], 404);
    }

    return response()->json($planta);
}




    // Obtener los datos de familia, especie y descubridor para selects
    public function getSelectData()
    {
        $familias = Familia::all();
        $descubridores = Descubridores::all();
        $especies = EspRelac::all();

        return response()->json([
            'familias' => $familias,
            'descubridores' => $descubridores,
            'especies' => $especies
        ]);
    }

    public function search(Request $request)
{
    $query = $request->input('query', '');

    $plantas = Plantas::where('nombre_comun', 'LIKE', "%{$query}%")
        ->orWhere('nombre_cientifico', 'LIKE', "%{$query}%")
        ->with(['familia', 'descubridor', 'especiesRelacionadas','lugarOrigen'])
        ->get();

    return response()->json($plantas);
}


    public function create(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'nombre_comun' => 'required|string|max:100',
            'nombre_cientifico' => 'required|string|max:100',
            'otros_nombres' => 'nullable|string|max:150',
            'familia_id' => 'required|exists:familia,id',
            'lugar_origen' => 'nullable|exists:pais,id',
            'cientifico_descubridor_id' => 'nullable|exists:descubridores,id',
            'descripcion' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'especies_relacionadas_id' => 'nullable|exists:esp_relac,id',
            'uso' => 'nullable|string',
            'estatus' => 'boolean'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $data = $request->all();

        // Guardar la foto si se carga
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $fotoArchivo = $request->file('foto');
            $nombreArchivo = time() . '-' . str_replace(' ', '_', $request->nombre_comun) . '.' . $fotoArchivo->getClientOriginalExtension();
            $fotoArchivo->move(public_path('assets/img/plantas'), $nombreArchivo);
            $data['foto'] = $nombreArchivo;
        } else {
            $data['foto'] = '0.jpg';
        }

        Plantas::create($data);

        return redirect()->route('admin.plantas')->with('success', 'Planta agregada exitosamente');
    }


    public function edit($id)
    {
        $planta = Plantas::with(['familia', 'descubridor', 'especiesRelacionadas', 'lugarOrigen'])->find($id);
        $familias = Familia::all();
        $descubridores = Descubridores::all();
        $paises = Pais::all();
        $especiesRelacionadas = EspRelac::all();

        if (!$planta) {
            return response()->json(['message' => 'Planta no encontrada'], 404);
        }

        return response()->json([
            'planta' => $planta,
            'familias' => $familias,
            'descubridores' => $descubridores,
            'paises' => $paises,
            'especiesRelacionadas' => $especiesRelacionadas
        ]);
    }



public function update(Request $request, $id)
{
    $planta = Plantas::find($id);

    if (!$planta) {
        return redirect()->route('admin.plantas')->with('error', 'Planta no encontrada');
    }

    $valid = Validator::make($request->all(), [
        'nombre_comun' => 'required|string|max:100',
        'nombre_cientifico' => 'required|string|max:100',
        'otros_nombres' => 'nullable|string|max:150',
        'familia_id' => 'required|exists:familia,id',
        'lugar_origen' => 'nullable|exists:pais,id',
        'cientifico_descubridor_id' => 'nullable|exists:descubridores,id',
        'descripcion' => 'nullable|string',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'especies_relacionadas_id' => 'nullable|exists:esp_relac,id',
        'uso' => 'nullable|string',
        'estatus' => 'boolean'
    ]);

    if ($valid->fails()) {
        return redirect()->back()->withErrors($valid)->withInput();
    }

    $data = $request->all();

    if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
        $fotoArchivo = $request->file('foto');
        $nombreArchivo = time() . '-' . str_replace(' ', '_', $request->nombre_comun) . '.' . $fotoArchivo->getClientOriginalExtension();
        $fotoArchivo->move(public_path('assets/img/plantas'), $nombreArchivo);
        $data['foto'] = $nombreArchivo;
    } else {
        $data['foto'] = $planta->foto;
    }

    $planta->update($data);

    return redirect()->route('admin.plantas')->with('success', 'Planta actualizada exitosamente');
}


    public function delete($id)
    {
        $planta = Plantas::find($id);

        if (!$planta) {
            return redirect()->route('admin.plantas')->with('error', 'Planta no encontrada');
        }

        $planta->delete();

        return redirect()->route('admin.plantas')->with('success', 'Planta eliminada exitosamente');
    }
}
