<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class FaceApiController extends Controller
{
    private $apiKey = 'Ymmw51lWcs0GF1KPSyKgfXNgvRzKtqcc'; // Tu API Key de Face++
    private $apiSecret = 'iUPfCXvZkKzVu9fmSBdzSRgMDjZzTwCv'; // Tu API Secret de Face++
    private $facePlusPlusUrl = 'https://api-us.faceplusplus.com/facepp/v3/detect'; // Endpoint de Face++

    // Método para iniciar sesión con Face ID
    public function loginWithFaceId(Request $request)
    {
        $request->validate([
            'image' => 'required|string', // La imagen debe estar en formato Base64
        ]);

        $imageData = $request->input('image');

        // Llamada a la API de Face++ para detectar la cara
        $response = Http::asForm()->post($this->facePlusPlusUrl, [
            'api_key' => $this->apiKey,
            'api_secret' => $this->apiSecret,
            'image_base64' => $imageData,
        ]);

        // Verificar la respuesta de la API
        if ($response->failed()) {
            return view('error')->with('message', 'Error en la detección facial.');
        }

        $faceData = $response->json();

        if (empty($faceData['faces'])) {
            return view('error')->with('message', 'No se detectó ninguna cara.');
        }

        // Obtener Face ID
        $faceId = $faceData['faces'][0]['face_token']; // Face++ usa `face_token` en lugar de `faceId`

        // Busca al usuario por el face_token almacenado
        $user = User::where('id_facial', $faceId)->first();

        if (!$user) {
            return view('error')->with('message', 'Usuario no encontrado.');
        }

        // Iniciar sesión con el usuario
        Auth::login($user);

        // Redirigir a la vista de perfil o la vista que desees
        return view('profile.index'); // Aquí puedes poner la vista que prefieras
    }

    // Método para registrar un nuevo Face ID
    public function registerFaceId(Request $request)
    {
        $request->validate([
            'image' => 'required|string', // La imagen debe estar en formato Base64
        ]);

        $imageData = $request->input('image');

        // Llamada a la API de Face++ para detectar la cara
        $response = Http::asForm()->post($this->facePlusPlusUrl, [
            'api_key' => $this->apiKey,
            'api_secret' => $this->apiSecret,
            'image_base64' => $imageData,
        ]);

        // Verificar la respuesta de la API
        if ($response->failed()) {
            return view('error')->with('message', 'Error en la detección facial.');
        }

        $faceData = $response->json();

        if (empty($faceData['faces'])) {
            return view('error')->with('message', 'No se detectó ninguna cara.');
        }

        // Obtener Face ID
        $faceId = $faceData['faces'][0]['face_token'];

        // Asocia el Face ID al usuario autenticado
        $user = Auth::user();
        if (!$user) {
            return view('error')->with('message', 'Usuario no autenticado.');
        }

        $user->id_facial = $faceId;
        $user->save();

        // Generar un nombre único para la imagen y guardarla en el servidor
        $imageName = uniqid() . '.png';
        $imageDataDecoded = base64_decode($imageData);
        $imagePath = public_path('uploads/faceid_images/' . $imageName);

        // Crear el directorio si no existe
        if (!file_exists(public_path('uploads/faceid_images'))) {
            mkdir(public_path('uploads/faceid_images'), 0777, true);
        }

        // Guardar la imagen en el servidor
        file_put_contents($imagePath, $imageDataDecoded);

        // Redirigir a la vista con la imagen capturada y la URL de la imagen
        return view('profile.edit-profile', [
            'capturedImage' => asset('uploads/faceid_images/' . $imageName),
            'user' => $user, // Pasa la variable $user a la vista
        ]);
    }
}
