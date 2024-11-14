<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pais;
use App\Models\TipoUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('dashboard');  // Esta es la vista por defecto para los usuarios
    }
    public function showUsers()
    {
        $users = User::with(['pais', 'tipoUser'])->get();
        $paises = Pais::all();
        $tipoUsers = TipoUser::all();
        return view('admin.usuarios', compact('users', 'paises', 'tipoUsers'));
    }

    public function indextwo()
    {
        $users = User::with(['pais', 'tipoUser'])->get();
        return response()->json($users, 200);
    }

    public function show($id)
    {
        $user = User::with(['pais', 'tipoUser'])->find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json($user);
    }

    public function edit($id)
    {
        $user = User::with(['pais', 'tipoUser'])->find($id);
        $paises = Pais::all();
        $tipoUsers = TipoUser::all();

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json([
            'user' => $user,
            'paises' => $paises,
            'tipoUsers' => $tipoUsers,
        ]);
    }

    public function create(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'tipo_user_id' => 'nullable|exists:tipo_users,id',
            'pais_id' => 'nullable|exists:pais,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $data = $request->except('password');
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $fotoArchivo = $request->file('foto');
            $nombreArchivo = time() . '-' . $data['name'] . '.' . $fotoArchivo->getClientOriginalExtension();
            $fotoArchivo->move(public_path('assets/img/users'), $nombreArchivo);
            $data['foto'] = $nombreArchivo;
        } else {
            $data['foto'] = 'default.jpg';
        }

        User::create($data);
        return redirect()->route('admin.usuarios')->with('success', 'Usuario agregado exitosamente');
    }

    public function search(Request $request)
    {
        $query = $request->input('query', '');
        $users = User::where('name', 'LIKE', "%{$query}%")
            ->with(['pais', 'tipoUser'])
            ->get();

        return response()->json($users);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $valid = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'tipo_user_id' => 'nullable|exists:tipo_users,id',
            'pais_id' => 'nullable|exists:pais,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $data = $request->except('password');

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $fotoArchivo = $request->file('foto');
            $nombreArchivo = time() . '-' . $data['name'] . '.' . $fotoArchivo->getClientOriginalExtension();
            $fotoArchivo->move(public_path('assets/img/users'), $nombreArchivo);
            $data['foto'] = $nombreArchivo;
        }

        $user->update($data);
        return redirect()->route('admin.usuarios')->with('success', 'Usuario actualizado exitosamente');
    }

    public function delete($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $user->delete();
        return redirect()->route('admin.usuarios')->with('success', 'Usuario eliminado exitosamente');
    }
}
