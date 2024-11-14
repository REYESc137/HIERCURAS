<?php
namespace App\Http\Controllers;

use App\Models\CalificacionReceta;
use App\Models\ComentarioReceta;
use App\Models\Recetas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ComentariosCalificacionesController extends Controller
{
    /**
     * Método para mostrar el detalle de una receta
     */
    public function showDetalleReceta($id)
    {
        // Obtener la receta con sus comentarios y calificaciones
        $receta = Recetas::with(['dificultad', 'planta', 'comentarios', 'calificaciones'])->findOrFail($id);

        // Calcular el promedio de calificación
        $promedioCalificacion = CalificacionReceta::where('receta_id', $id)->avg('calificacion');
        $promedioCalificacion = round($promedioCalificacion, 1); // Redondear a un decimal
        $promedioCalificacion = $promedioCalificacion ?: 0; // Si no hay calificaciones, poner 0

        // Pasar datos a la vista
        return view('detalle-recetas', [
            'receta' => $receta,
            'promedioCalificacion' => $promedioCalificacion,
            'tipoUser' => Auth::check() ? Auth::user()->tipo_user_id : null // Pasar el tipo de usuario
        ]);
    }

    /**
     * Método para guardar un comentario en una receta
     */
    public function storeComentario(Request $request)
{
    $request->validate([
        'comentario' => 'required|string|max:255',
        'receta_id' => 'required|exists:recetas,id',
    ]);

    // Crear un nuevo comentario y asignar los valores
    $comentario = new ComentarioReceta();
    $comentario->comentario = $request->comentario;
    $comentario->receta_id = $request->receta_id;

    // Asignar el ID del usuario autenticado
    if (Auth::check()) {
        $comentario->usuario_id = Auth::id();
    } else {
        // Si no está autenticado, podrías manejarlo de otra manera, pero como ya estás mostrando un modal para login, esto no debería ocurrir
        return redirect()->route('login');
    }

    $comentario->save();

    return redirect()->route('detalle-recetas', ['id' => $comentario->receta_id]);
}
public function editComentario($id)
{
    $comentario = ComentarioReceta::findOrFail($id);

    // Verificar si el comentario pertenece al usuario autenticado
    if ($comentario->usuario_id != Auth::id()) {
        return redirect()->route('detalle-recetas', ['id' => $comentario->receta_id])
                         ->with('error', 'No tienes permiso para editar este comentario');
    }

    return view('comentarios.edit', compact('comentario'));
}


    /**
     * Método para actualizar un comentario existente
     */
    public function updateComentario(Request $request, $id)
    {
        $comentario = ComentarioReceta::findOrFail($id);

        // Verificar si el comentario pertenece al usuario autenticado
        if ($comentario->usuario_id != Auth::id()) {
            return redirect()->route('detalle-recetas', ['id' => $comentario->receta_id])
                             ->with('error', 'No tienes permiso para editar este comentario');
        }

        $comentario->comentario = $request->comentario;
        $comentario->save();

        return redirect()->route('detalle-recetas', ['id' => $comentario->receta_id])
                         ->with('success', 'Comentario actualizado correctamente.');
    }



    /**
     * Método para eliminar un comentario
     */
    public function deleteComentario($id)
{
    $comentario = ComentarioReceta::find($id);

    // Verifica si el comentario existe y si el usuario autenticado es el propietario
    if (!$comentario || $comentario->usuario_id != Auth::id()) {
        return redirect()->route('detalle-recetas', ['id' => $comentario->receta_id])
                         ->with('error', 'No tienes permiso para eliminar este comentario.');
    }

    $receta_id = $comentario->receta_id;
    $comentario->delete();

    return redirect()->route('detalle-recetas', ['id' => $receta_id])
                     ->with('success', 'Comentario eliminado exitosamente');
}


    /**
     * Método para guardar una calificación de receta
     */

    public function storeCalificacion(Request $request)
{
    $validated = $request->validate([
        'receta_id' => 'required|exists:recetas,id',
        'calificacion' => 'required|integer|between:1,5',
    ]);

    // Verificar si el usuario ya ha calificado la receta
    $calificacion = CalificacionReceta::where('usuario_id', Auth::id()) // Usando 'usuario_id'
                                       ->where('receta_id', $request->receta_id)
                                       ->first();

    if ($calificacion) {
        // Si ya existe una calificación, actualizarla
        $calificacion->calificacion = $request->calificacion;
        $calificacion->save();
    } else {
        // Si no existe, crear una nueva calificación
        CalificacionReceta::create([
            'receta_id' => $request->receta_id,
            'usuario_id' => Auth::id(), // Usando 'usuario_id'
            'calificacion' => $request->calificacion,
        ]);
    }

    // Redirigir con mensaje de éxito
    return redirect()->route('detalle-recetas', $request->receta_id)
                     ->with('success', 'Calificación actualizada exitosamente.');
}

}
