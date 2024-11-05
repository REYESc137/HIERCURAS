<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    // Redirigir a Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    // Manejar la respuesta de Google
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/')->withErrors('No se pudo acceder a Google.');
        }
        // Verifica si el usuario ya existe en tu base de datos
        $authUser = $this->findOrCreateUser($user);
        // Iniciar sesión
        Auth::login($authUser, true);
        // Mostrar modal para establecer contraseña si es un nuevo usuario
        if (!$authUser->password_set) {
            return redirect()->route('dashboard')->with('showPasswordModal', true);
        }
        return redirect()->route('dashboard');
    }
    // Busca o crea un nuevo usuario
    private function findOrCreateUser($googleUser)
    {
        $authUser = User::where('email', $googleUser->getEmail())->first();
        if ($authUser) {
            return $authUser;
        }
        // Crea un nuevo usuario
        return User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'password' => Hash::make(Str::random(16)), // Genera una contraseña aleatoria
            'password_set' => false, // Marca que el usuario no ha establecido una contraseña
        ]);
    }
    // Establecer contraseña para el usuario
    public function setPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->password_set = true; // Marca que el usuario ha establecido una contraseña
        $user->save();
        return redirect()->route('dashboard')->with('status', 'Contraseña establecida correctamente.');
    }
    // Método de cierre de sesión
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/')->with('status', 'Desconectado correctamente.');
    }
}