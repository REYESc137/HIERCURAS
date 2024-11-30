<?php
use App\Http\Controllers\FaceApiController;
use App\Http\Controllers\Api\PlantasController;
use App\Http\Controllers\Api\DescubridoresController;
use App\Http\Controllers\Api\RecetasController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*----- Página principal -----*/
Route::get('/', function () {
    return view('welcome');
});

// web.php
Route::get('/api/plantas', [PlantasController::class, 'obtenerPlantas'])->name('api.plantas');


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

Route::prefix('admin')->group(function () {
    Route::get('/usuarios', [UserController::class, 'showUsers'])->name('admin.usuarios');
    Route::post('/usuarios', [UserController::class, 'create'])->name('usuarios.create');
    Route::patch('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');
    Route::get('/usuarios/search', [UserController::class, 'search'])->name('usuarios.search');
    Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuarios.show');
    Route::get('/usuarios/{id}/edit', [UserController::class, 'edit'])->name('usuarios.edit');
    Route::delete('/usuarios/{id}', [UserController::class, 'delete'])->name('usuarios.delete');
});


/*----- Vistas públicas accesibles sin iniciar sesión -----*/
Route::get('/plantas-medicinales', [PageController::class, 'plantasMedicinales'])->name('plantas.medicinales');
Route::get('/descubridores', [PageController::class, 'descubridores'])->name('descubridores');
Route::get('/metodos-elaboracion', [PageController::class, 'metodosElaboracion'])->name('metodos.elaboracion');
use App\Http\Controllers\ComentariosCalificacionesController;

// Ruta para mostrar el detalle de la receta
Route::get('/detalle-receta/{id}', [ComentariosCalificacionesController::class, 'showDetalleReceta'])->name('detalle-recetas');

// Rutas para comentarios
Route::post('/comentarios', [ComentariosCalificacionesController::class, 'storeComentario'])->name('store-comentario');
Route::put('/comentarios/{id}', [ComentariosCalificacionesController::class, 'updateComentario'])->name('update-comentario');
Route::delete('/comentarios/{id}', [ComentariosCalificacionesController::class, 'deleteComentario'])->name('delete-comentario');

Route::get('comentarios/{comentario}/edit', [ComentariosCalificacionesController::class, 'edit'])->name('edit-comentario');
Route::put('comentarios/{comentario}', [ComentariosCalificacionesController::class, 'update'])->name('update-comentario');
Route::delete('comentarios/{comentario}', [ComentariosCalificacionesController::class, 'destroy'])->name('delete-comentario');


// Ruta para calificación
Route::post('/calificacion', [ComentariosCalificacionesController::class, 'storeCalificacion'])->name('store-calificacion');



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

// Ruta para el registro de Face ID
Route::post('/faceid/register', [FaceApiController::class, 'registerFaceId'])->name('faceid.register');

require __DIR__ . '/auth.php';


Route::post('pay', [PaymentController::class, 'pay'])->name('payment');
Route::get('success', [PaymentController::class, 'success']);
Route::get('error', [PaymentController::class, 'error']);
