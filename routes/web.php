<?php
use App\Http\Controllers\Api\PlantasController;
use App\Http\Controllers\Api\DescubridoresController;
use App\Http\Controllers\Api\RecetasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*----- Página principal -----*/
Route::get('/', function () {
    return view('welcome');
});

/*----- Rutas para Descubridores -----*/
Route::prefix('admin')->group(function () {
    Route::get('/descubridores', [DescubridoresController::class, 'showDiscoverers'])->name('admin.descubridores');
    Route::post('/descubridores', [DescubridoresController::class, 'create'])->name('descubridores.create');
    Route::patch('/descubridores/{id}', [DescubridoresController::class, 'update'])->name('descubridores.update');
    Route::get('/descubridores/search', [DescubridoresController::class, 'search'])->name('descubridores.search');
    Route::get('/descubridores/{id}', [DescubridoresController::class, 'show'])->name('descubridores.show');
    Route::get('/descubridores/{id}/edit', [DescubridoresController::class, 'edit'])->name('descubridores.edit');
    Route::delete('/descubridores/{id}', [DescubridoresController::class, 'delete'])->name('descubridores.delete');
});

/*----- Rutas para Plantas -----*/
Route::prefix('admin')->group(function () {
    Route::get('/plantas', [PlantasController::class, 'showPlants'])->name('admin.plantas');
    Route::post('/plantas', [PlantasController::class, 'create'])->name('plantas.create');
    Route::patch('/plantas/{id}', [PlantasController::class, 'update'])->name('plantas.update');
    Route::get('/plantas/search', [PlantasController::class, 'search'])->name('plantas.search');
    Route::get('/plantas/{id}', [PlantasController::class, 'show'])->name('plantas.show');
    Route::get('/plantas/{id}/edit', [PlantasController::class, 'edit'])->name('plantas.edit');
    Route::delete('/plantas/{id}', [PlantasController::class, 'delete'])->name('plantas.delete');
});

/*----- Rutas para Recetas -----*/
Route::prefix('admin')->group(function () {
    Route::get('/recetas', [RecetasController::class, 'showRecipes'])->name('admin.recetas');
    Route::post('/recetas', [RecetasController::class, 'create'])->name('recetas.create');
    Route::patch('/recetas/{id}', [RecetasController::class, 'update'])->name('recetas.update');
    Route::get('/recetas/search', [RecetasController::class, 'search'])->name('recetas.search');
    Route::get('/recetas/{id}', [RecetasController::class, 'show'])->name('recetas.show');
    Route::get('/recetas/{id}/edit', [RecetasController::class, 'edit'])->name('recetas.edit');
    Route::delete('/recetas/{id}', [RecetasController::class, 'delete'])->name('recetas.delete');
});

/*----- Vistas públicas accesibles sin iniciar sesión -----*/
Route::get('/plantas-medicinales', [PageController::class, 'plantasMedicinales'])->name('plantas.medicinales');
Route::get('/descubridores', [PageController::class, 'descubridores'])->name('descubridores');
Route::get('/metodos-elaboracion', [PageController::class, 'metodosElaboracion'])->name('metodos.elaboracion');

/*----- Rutas de autenticación -----*/
Route::post('/set-password', [AuthController::class, 'setPassword'])->name('set.password');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

/*----- Rutas protegidas para administradores (tipo_user_id == 1) -----*/
Route::middleware('auth')->group(function () {
    Route::get('/admin', function () {
        return Auth::user()->tipo_user_id == 1
            ? view('admin.index')
            : redirect('/dashboard')->with('error', 'No tienes acceso a esta página.');
    })->name('admin.index');

    Route::get('/admin/usuarios', function () {
        return Auth::user()->tipo_user_id == 1
            ? view('admin.usuarios')
            : redirect('/dashboard')->with('error', 'No tienes acceso a esta página.');
    })->name('admin.usuarios');

    Route::get('/admin/profile', [ProfileController::class, 'editAdmin'])->name('admin.profile.edit');
    Route::patch('/admin/profile', [ProfileController::class, 'updateAdmin'])->name('admin.profile.update');
    Route::delete('/admin/profile', [ProfileController::class, 'destroyAdmin'])->name('admin.profile.destroy');
});

/*----- Rutas protegidas para usuarios normales (tipo_user_id == 2 o 3) -----*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return in_array(Auth::user()->tipo_user_id, [2, 3])
            ? view('dashboard')
            : redirect('/admin')->with('error', 'No tienes acceso a esta página.');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
