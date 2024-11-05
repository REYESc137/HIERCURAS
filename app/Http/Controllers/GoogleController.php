<?php
namespace App\Http\Controllers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Asegúrate de que este modelo exista
class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            // Aquí puedes encontrar o crear el usuario en tu base de datos
            $user = User::where('email', $googleUser->getEmail())->first();
            if (!$user) {
                // Si no existe, crea uno nuevo
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(Str::random(16)), // Genera una contraseña aleatoria
                ]);
            }
            // Autenticar al usuario en tu aplicación
            Auth::login($user);
            // Redirigir a donde necesites después de iniciar sesión
            return redirect()->route('home'); // Cambia 'home' por la ruta que desees
        } catch (\Exception $e) {
            // Manejar la excepción
            return redirect('/login')->with('error', 'Error en la autenticación con Google.');
        }
    }
}