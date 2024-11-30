@extends('layouts.metodos-elaboracion_layouts')

@section('content')
<div class="container my-5">
    <header class="mb-5" style="text-align: center; background-color: #f8f9fa; padding: 20px; border-radius: 10px;">
        <h1 class="display-4" style="font-size: 2.5rem; font-weight: bold; color: #333;">{{ $receta->nombre }}</h1>
        <p class="lead" style="font-size: 1.1rem; color: #333;">
            Dificultad: {{ $receta->dificultad ? $receta->dificultad->nombre : 'Desconocida' }} ·
            Tiempo de preparación: {{ $receta->tiempo_preparacion }} mins
        </p>
        <div style="font-size: 1.2rem; color: #28a745; font-weight: bold;">
            <span id="rating-stars" style="font-size: 1.5rem;"></span>
            <p style="color: #6c757d;">({{ $promedioCalificacion }} / 5) · {{ count($receta->comentarios) }} comentarios</p>
        </div>
    </header>

    <div class="row">
        <!-- Imagen de la receta -->
        <div class="col-md-5">
            <img src="{{ asset('assets/img/recetas/' . ($receta->foto ?? 'receta.jpg')) }}"
                 alt="Imagen de {{ $receta->nombre }}"
                 class="img-fluid rounded receta-img">
        </div>

        <!-- Detalles de la receta -->
        <div class="col-md-7">
            <div class="mb-4">
                <h3>Ingredientes</h3>
                <p>{{ $receta->ingredientes }}</p>
            </div>

            <div class="mb-4">
                <h3>Preparación</h3>
                <p>{{ $receta->preparacion }}</p>
            </div>

            <!-- Sección de calificación -->
            <div class="mt-5">
                <h3>Calificación</h3>
                <p><strong>Promedio:</strong> {{ number_format($promedioCalificacion, 1) }} / 5</p>

                <form action="{{ route('store-calificacion') }}" method="POST">
                    @csrf
                    <input type="hidden" name="receta_id" value="{{ $receta->id }}">

                    <label for="calificacion">Tu calificación:</label>
                    <select name="calificacion" class="form-control w-100 d-inline-block" required>
                        <option value="1" {{ old('calificacion') == 1 ? 'selected' : '' }}>1</option>
                        <option value="2" {{ old('calificacion') == 2 ? 'selected' : '' }}>2</option>
                        <option value="3" {{ old('calificacion') == 3 ? 'selected' : '' }}>3</option>
                        <option value="4" {{ old('calificacion') == 4 ? 'selected' : '' }}>4</option>
                        <option value="5" {{ old('calificacion') == 5 ? 'selected' : '' }}>5</option>
                    </select>

                    @if($errors->has('calificacion'))
                        <div class="alert alert-danger mt-2">{{ $errors->first('calificacion') }}</div>
                    @endif

                    @auth
                        <button type="submit" class="btn btn-primary mt-2">Calificar</button>
                    @else
                        <!-- Si no está autenticado, abrir modal -->
                        <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#authModal">Calificar</button>
                    @endauth
                </form>
            </div>

        </div>
    </div>

    <!-- Sección de comentarios -->
    <section class="mt-5">
    <h3>Comentarios</h3>
    @foreach($receta->comentarios as $comentario)
    <div class="border rounded p-3 mb-3 position-relative">
        <strong>{{ $comentario->user->name }}:</strong>
        <p class="comentario-text">{{ $comentario->comentario }}</p>

        @if(Auth::check() && Auth::id() == $comentario->usuario_id)
        <!-- Botones de edición y eliminación en la esquina superior derecha -->
            <div class="position-absolute top-0 right-0">
                <button type="button" class="btn btn-sm btn-link text-primary" onclick="toggleEditForm({{ $comentario->id }})">Editar</button>
                <!-- Formulario de eliminación -->
                <form action="{{ route('delete-comentario', $comentario->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-link text-danger" onclick="return confirm('¿Estás seguro de eliminar este comentario?')">Eliminar</button>
                </form>
            </div>

            <!-- Formulario de edición (oculto por defecto) -->
            <div id="edit-form-{{ $comentario->id }}" style="display: none; margin-top: 10px;">
                <form action="{{ route('update-comentario', $comentario->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <textarea name="comentario" class="form-control" required>{{ old('comentario', $comentario->comentario) }}</textarea>
                    <button type="submit" class="btn btn-primary mt-2">Actualizar Comentario</button>
                </form>
            </div>
        @endif
    </div>
    @endforeach





        @auth
            <div class="mt-4">
                <h4>Agregar comentario</h4>
                <form action="{{ route('store-comentario') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <textarea name="comentario" class="form-control" placeholder="Escribe tu comentario" required></textarea>
                        @if($errors->has('comentario'))
                            <div class="alert alert-danger mt-2">{{ $errors->first('comentario') }}</div>
                        @endif
                    </div>
                    <input type="hidden" name="receta_id" value="{{ $receta->id }}">
                    <button type="submit" class="btn btn-primary mt-2">Comentar</button>
                </form>
            </div>
        @else
            <!-- Si no está autenticado, abrir modal -->
            <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#authModal">Comentar</button>
        @endauth
    </section>
</div>

<!-- Modal para el caso de no estar autenticado -->
<div class="modal fade" id="authModal" tabindex="-1" role="dialog" aria-labelledby="authModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="authModalLabel">Accede a tu cuenta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Para calificar o comentar, necesitas estar autenticado. ¿Qué te gustaría hacer?</p>
            </div>
            <div class="modal-footer">
                <a href="{{ route('login') }}" class="btn btn-primary">Iniciar sesión</a>
                <a href="{{ route('register') }}" class="btn btn-secondary">Registrarse</a>
            </div>
        </div>
    </div>
</div>

<style>
    .receta-img {
        width: 100%; /* La imagen ocupa el 100% del contenedor */
        height: 300px; /* Fija la altura de la imagen */
        object-fit: cover; /* Asegura que la imagen se recorte y ajuste bien al contenedor sin distorsionarse */
        border-radius: 10px; /* Redondea los bordes de la imagen */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Opcional, añade sombra para darle un efecto de profundidad */
    }

    .star-rating {
        color: #FFD700; /* Color dorado para las estrellas llenas */
    }

    .star-rating-half {
        color: #FFCC00; /* Color amarillo para las estrellas a medio llenar */
    }

    .star-rating-empty {
        color: #D3D3D3; /* Color gris para las estrellas vacías */
    }
    .comentario-text {
        margin-bottom: 10px;
    }

    .position-absolute {
        position: absolute;
    }

    .top-0 {
        top: 0;
    }

    .right-0 {
        right: 0;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const promedioCalificacion = {{ $promedioCalificacion }}; // Promedio de la calificación
        const ratingStarsContainer = document.getElementById('rating-stars');
        const totalStars = 5; // Total de estrellas a mostrar

        function getStarClass(rating) {
            if (rating >= 1) return 'star-rating';
            if (rating >= 0.5) return 'star-rating-half';
            return 'star-rating-empty';
        }

        function generateStars(rating) {
            let starsHtml = '';
            for (let i = 1; i <= totalStars; i++) {
                const filled = rating >= i ? 1 : (rating >= (i - 0.5) ? 0.5 : 0);
                starsHtml += `<i class="fa fa-star ${getStarClass(filled)}"></i>`;
            }
            return starsHtml;
        }

        // Mostrar las estrellas con base en el promedio
        ratingStarsContainer.innerHTML = generateStars(promedioCalificacion);
    });
</script>

<script>
    function toggleEditForm(commentId) {
        const form = document.getElementById('edit-form-' + commentId);
        // Alterna la visibilidad del formulario
        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    }
</script>


<!-- Asegúrate de que estos scripts estén cargados correctamente -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection

@section('footer')

<!-- Footer Section (tonos más suaves) -->
<div class="pt-5 mt-5 container-fluid bg-[#8B4513] text-white-50 footer"> <!-- Marrón tierra para el footer -->
    <div class="container py-5">
        <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
            <div class="row g-4">
                <div class="col-lg-3">
                    <a href="#">
                        <img src="{{ asset('assets/img/Hiercura_logo.png') }}" alt="Hiercura" width="70" height="70">
                        <h1 class="mb-0 text-white">Hiercura</h1>
                        <p class="mb-0 text-white-50">Cuidando tu salud, a lo natural</p>
                    </a>
                </div>
                <div class="col-lg-6">
                    @if (Auth::check() && Auth::user()->tipo_user_id != 3)
                    <form action="{{ route('payment')}}" method="post">
                        @csrf
                    <div class="mx-auto position-relative">
                        <input class="px-4 py-3 border-0 form-control w-100 rounded-pill" type="text" disabled
                            placeholder="Suscribete por $20 MXN al mes">
                            <input type="hidden" name="amount" value=20>
                        <button type="submit"
                            class="px-4 py-3 text-white border-0 btn btn-primary bg-[#6B8E23] position-absolute rounded-pill"
                            style="top: 0; right: 0;">Suscribirse</button>
                    </div>
                    </form>
                    @else
                    @if( !Auth::check() || Auth::user()->tipo_user_id != 3)
                    <div class="mx-auto position-relative">
                        <input class="px-4 py-3 border-0 form-control w-100 rounded-pill" type="text" disabled placeholder="Suscribete">
                        <a href="{{ route('login')}}" type="submit"
                            class="px-4 py-3 text-white border-0 btn btn-primary bg-[#6B8E23] position-absolute rounded-pill"
                            style="top: 0; right: 0;">Inicia  Sesión</a>
                    @endif
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection