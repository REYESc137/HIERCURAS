<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite; // Asegúrate de que Socialite esté instalado
use App\Models\User;
use Illuminate\Support\Str;
class LoginController extends Controller
{
    // Muestra el formulario de inicio de sesión
    public function showLoginForm()
    {
        return view('auth.login');
    }
    // Maneja el inicio de sesión
    public function login(Request $request)
    {
        // Valida las credenciales
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // Intenta autenticar al usuario
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Autenticación exitosa
            return redirect()->intended('dashboard');
        }
        // Si las credenciales son incorrectas
        return back()->withErrors([
            'email' => 'Estas credenciales no coinciden con nuestros registros.',
        ]);
    }
    // Método de cierre de sesión
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/')->with('status', 'Desconectado correctamente.');
    }
    // Redirige a Google para autenticación
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    // Maneja la respuesta de Google
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();
        // Busca al usuario por su correo electrónico
        $authUser = User::where('email', $googleUser->getEmail())->first();
        if (!$authUser) {
            // Si el usuario no existe, crear uno nuevo
            $authUser = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(Str::random(16)), // Genera una contraseña aleatoria
                'password_set' => false, // Marca que la contraseña no está establecida
            ]);
        }
        // Iniciar sesión con el usuario
        Auth::login($authUser, true);
        // Redirigir al dashboard y mostrar el modal si es un nuevo usuario
        return redirect()->route('dashboard')->with('showPasswordModal', !$authUser->password_set);
    }
}