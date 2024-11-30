@extends('layouts.metodos-elaboracion_layouts')

@section('content')
<header class="relative" style="background-image: url('{{ asset('assets/img/Metodosdeelaboracion.jpg') }}'); background-size: cover; background-position: center center; background-color: rgba(0, 0, 0, 0.5); background-blend-mode: darken;">
    <div class="flex items-center justify-between h-48 px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h1 class="text-5xl font-bold text-white dark:text-gray-200">
            {{ __('Métodos de Elaboración') }}
        </h1>
        <div class="input-group w-50">
            <input type="search" id="buscarReceta" class="p-3 form-control" placeholder="Buscar receta..." aria-describedby="search-icon-1">
            <span id="search-icon-1" class="p-3 input-group-text"><i class="fa fa-search"></i></span>
        </div>
    </div>
</header>

<main class="pt-6">
    <div class="container py-5">
        <div class="row g-4" id="listaRecetas">
            <!-- Aquí se insertarán dinámicamente las tarjetas de cada receta -->
        </div>
    </div>
</main>

<!-- Modal de detalles -->
<div class="modal fade" id="recetaDetailsModal" tabindex="-1" aria-labelledby="recetaDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="recetaDetailsModalLabel">Detalles de la Receta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="recetaDetailsContent">
                <!-- Contenido dinámico de los detalles de la receta -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="verMasBtn">Ver más detalles</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<style>
    .receta-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const buscarRecetaInput = document.getElementById('buscarReceta');
        const listaRecetas = document.getElementById('listaRecetas');
        const searchUrl = "{{ route('recetas.search') }}";
        const baseUrl = "{{ url('') }}";
        const defaultImagePath = "{{ asset('assets/img/receta.jpg') }}";

        function fetchRecetas(query = '') {
            const url = `${searchUrl}?query=${encodeURIComponent(query)}`;

            fetch(url)
                .then(response => response.json())
                .then(data => renderRecetas(data))
                .catch(error => {
                    console.error('Error al cargar recetas:', error);
                    listaRecetas.innerHTML = '<p class="text-center">Hubo un error al buscar las recetas.</p>';
                });
        }

        function renderRecetas(recetas) {
            listaRecetas.innerHTML = '';

            if (recetas.length > 0) {
                recetas.forEach(receta => {
                    const fotoPath = receta.foto ? `${baseUrl}/assets/img/recetas/${receta.foto}` : defaultImagePath;
                    const dificultad = receta.dificultad ? receta.dificultad.nombre : 'N/A';
                    const cardHtml = `
                        <div class="col-md-6 col-lg-4">
                            <div class="rounded position-relative border border-secondary">
                                <div>
                                    <img src="${fotoPath}" class="img-fluid receta-img" alt="Imagen de ${receta.nombre}" onerror="this.src='${defaultImagePath}'">
                                </div>
                                <div class="p-4">
                                    <h4>${receta.nombre}</h4>
                                    <p><strong>Dificultad:</strong> ${dificultad}</p>
                                    <button type="button" class="mt-3 btn btn-primary" data-bs-toggle="modal" data-bs-target="#recetaDetailsModal" onclick="loadRecetaDetails(${receta.id})">
                                        Ver Detalles
                                    </button>
                                    <button type="button" class="mt-3 btn btn-info" onclick="redirectToDetails(${receta.id})">
                                        Ver Más
                                    </button>
                                </div>
                            </div>
                        </div>`;
                    listaRecetas.insertAdjacentHTML('beforeend', cardHtml);
                });
            } else {
                listaRecetas.innerHTML = '<p class="text-center">No se encontraron recetas.</p>';
            }
        }

        function loadRecetaDetails(id) {
            fetch(`${baseUrl}/admin/recetas/${id}`)
                .then(response => response.json())
                .then(data => {
                    const planta = data.planta ? data.planta.nombre_comun || data.planta.nombre : 'N/A';
                    const ingredientes = data.ingredientes || 'N/A';
                    const preparacion = data.preparacion || 'N/A';
                    const tiempoPreparacion = data.tiempo_preparacion ? `${data.tiempo_preparacion} minutos` : 'N/A';
                    const dificultad = data.dificultad ? data.dificultad.nombre : 'N/A';

                    document.getElementById('recetaDetailsContent').innerHTML = `
                        <div class="text-center">
                            <img src="${data.foto ? `${baseUrl}/assets/img/recetas/${data.foto}` : defaultImagePath}"
                                 alt="Imagen de ${data.nombre}"
                                 class="mb-3 img-fluid rounded-circle"
                                 style="width: 150px; height: 150px; object-fit: cover;"
                                 onerror="this.src='${defaultImagePath}'">
                        </div>
                        <p><strong>Nombre:</strong> ${data.nombre}</p>
                        <p><strong>Ingredientes:</strong> ${ingredientes}</p>
                        <p><strong>Instrucciones:</strong> ${preparacion}</p>
                        <p><strong>Tiempo de preparación:</strong> ${tiempoPreparacion}</p>
                        <p><strong>Dificultad:</strong> ${dificultad}</p>
                        <p><strong>Planta relacionada:</strong> ${planta}</p>
                    `;
                    document.getElementById('verMasBtn').addEventListener('click', function() {
                        window.location.href = "{{ route('detalle-recetas', ['id' => '__id__']) }}".replace('__id__', data.id);
                    });
                })
                .catch(error => {
                    console.error('Error al cargar detalles:', error);
                    document.getElementById('recetaDetailsContent').innerHTML = `<p>Error al cargar detalles: ${error.message}</p>`;
                });
        }

        // Redirige a la página de detalles
        function redirectToDetails(id) {
            window.location.href = "{{ route('detalle-recetas', ['id' => '__id__']) }}".replace('__id__', id);
        }

        window.loadRecetaDetails = loadRecetaDetails;
        window.redirectToDetails = redirectToDetails;

        buscarRecetaInput.addEventListener('input', () => {
            const query = buscarRecetaInput.value.trim();
            fetchRecetas(query);
        });

        fetchRecetas();
    });
</script>

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