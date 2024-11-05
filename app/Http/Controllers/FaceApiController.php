<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FaceApiController extends Controller
{
    private $subscriptionKey = '7d4QLgYBSCgb4lL9kdGfWE1DEkaQ42AAOkXzLVffxGnVSu8GvsJQQJ99AKACYeBjFXJ3w3AAAKACOGPrjh'; // Tu clave de suscripción
    private $endpoint = 'https://faceapiproyectohiercura.cognitiveservices.azure.com/face/v1.0/'; // Tu endpoint

    // Método para iniciar sesión con Face ID
    public function loginWithFaceId(Request $request)
    {
        $request->validate([
            'image' => 'required|string', // La imagen debe estar en formato Base64
        ]);

        $imageData = $request->input('image');

        // Llama a la API de Azure para detectar la cara
        $response = Http::withHeaders([
            'Ocp-Apim-Subscription-Key' => $this->subscriptionKey,
            'Content-Type' => 'application/json'
        ])->post($this->endpoint . 'detect', [
            'data' => base64_decode($imageData), // Se asume que se envía la imagen en formato Base64
            'returnFaceId' => true,
        ]);

        // Verifica la respuesta de la API
        if ($response->failed()) {
            return response()->json(['success' => false, 'message' => 'Error en la detección facial.'], $response->status());
        }

        $faceData = $response->json();

        if (empty($faceData)) {
            return response()->json(['success' => false, 'message' => 'No se detectó ninguna cara.'], 404);
        }

        $faceId = $faceData[0]['faceId']; // Obtiene el ID de la cara detectada

        // Busca al usuario por su ID facial almacenado en la base de datos
        $user = User::where('id_facial', $faceId)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Usuario no encontrado.'], 404);
        }

        // Inicia sesión con el usuario
        Auth::login($user);

        return response()->json(['success' => true, 'message' => 'Inicio de sesión exitoso.']);
    }

    // Método para registrar un nuevo Face ID
    public function registerFaceId(Request $request)
    {
        $request->validate([
            'image' => 'required|string', // La imagen debe estar en formato Base64
        ]);

        $imageData = $request->input('image');

        // Llama a la API de Azure para detectar la cara
        $response = Http::withHeaders([
            'Ocp-Apim-Subscription-Key' => $this->subscriptionKey,
            'Content-Type' => 'application/json'
        ])->post($this->endpoint . 'detect', [
            'data' => base64_decode($imageData), // Se asume que se envía la imagen en formato Base64
            'returnFaceId' => true,
        ]);

        // Verifica la respuesta de la API
        if ($response->failed()) {
            return response()->json(['success' => false, 'message' => 'Error en la detección facial.'], $response->status());
        }

        $faceData = $response->json();

        if (empty($faceData)) {
            return response()->json(['success' => false, 'message' => 'No se detectó ninguna cara.'], 404);
        }

        $faceId = $faceData[0]['faceId']; // Obtiene el ID de la cara detectada

        // Asocia el Face ID al usuario autenticado
        $user = Auth::user();
        $user->id_facial = $faceId;
        $user->save();

        return response()->json(['success' => true, 'message' => 'Face ID registrado exitosamente.']);
    }

    // Método para guardar la imagen en el servidor
    public function storeImage(Request $request)
    {
        $request->validate([
            'image' => 'required|string', // Asegúrate de que la imagen esté en formato Base64
        ]);

        $imageData = $request->input('image');

        // Si la imagen está en formato Base64, quitar el prefijo
        if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
            $imageData = substr($imageData, strpos($imageData, ',') + 1);
            $imageData = base64_decode($imageData);
            if ($imageData === false) {
                return response()->json(['success' => false, 'message' => 'Datos de imagen no válidos.'], 400);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Formato de imagen no válido.'], 400);
        }

        $imageName = 'face_' . time() . '.jpg';
        $path = 'assets/img/' . $imageName;

        // Decodifica la imagen y la guarda en el directorio especificado
        Storage::disk('public')->put($path, $imageData);

        // Verificar si la imagen se guardó correctamente
        if (Storage::disk('public')->exists($path)) {
            return response()->json(['success' => true, 'message' => 'Imagen guardada exitosamente.', 'path' => $path]);
        } else {
            return response()->json(['success' => false, 'message' => 'Error al guardar la imagen.'], 500);
        }
    }
}
