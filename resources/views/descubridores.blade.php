@extends('layouts.descubridores_layouts')

@section('content')
<header class="relative" style="background-image: url('{{ asset('assets/img/Descubridor.png') }}'); background-size: cover; background-position: center center; background-color: rgba(0, 0, 0, 0.5); background-blend-mode: darken;">
    <div class="flex items-center justify-between h-48 px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h1 class="text-5xl font-bold text-white dark:text-gray-200">
            {{ __('Descubridores') }}
        </h1>
        <div class="input-group w-50">
            <input type="search" id="buscarDescubridor" class="p-3 form-control" placeholder="Buscar descubridor..." aria-describedby="search-icon-1">
            <span id="search-icon-1" class="p-3 input-group-text"><i class="fa fa-search"></i></span>
        </div>
    </div>
</header>

<main class="pt-6">
    <div class="container py-5">
        <div class="row g-4" id="listaDescubridores">
            <!-- Aquí se insertarán dinámicamente las tarjetas de cada descubridor -->
        </div>
    </div>
</main>

<div class="modal fade" id="descubridorDetailsModal" tabindex="-1" aria-labelledby="descubridorDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="descubridorDetailsModalLabel">Detalles del Descubridor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="descubridorDetailsContent">
                <!-- Contenido dinámico de los detalles del descubridor -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<style>
    .descubridor-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const buscarDescubridorInput = document.getElementById('buscarDescubridor');
        const listaDescubridores = document.getElementById('listaDescubridores');
        const searchUrl = "{{ route('descubridores.search') }}";
        const baseUrl = "{{ url('') }}";
        const defaultImagePath = "{{ asset('assets/img/Descubridor.png') }}";

        function fetchDescubridores(query = '') {
            const url = `${searchUrl}?query=${encodeURIComponent(query)}`;

            fetch(url)
                .then(response => response.json())
                .then(data => renderDescubridores(data))
                .catch(error => {
                    console.error('Error al cargar descubridores:', error);
                    listaDescubridores.innerHTML = '<p class="text-center">Hubo un error al buscar los descubridores.</p>';
                });
        }

        function renderDescubridores(descubridores) {
            listaDescubridores.innerHTML = '';

            if (descubridores.length > 0) {
                descubridores.forEach(descubridor => {
                    const fotoPath = descubridor.foto ? `${baseUrl}/assets/img/descubridores/${descubridor.foto}` : defaultImagePath;
                    const pais = descubridor.pais ? descubridor.pais.nombre : 'N/A';
                    const cardHtml = `
                        <div class="col-md-6 col-lg-4">
                            <div class="rounded position-relative border border-secondary">
                                <div>
                                    <img src="${fotoPath}" class="img-fluid descubridor-img" alt="Imagen de ${descubridor.nombre}" onerror="this.src='${defaultImagePath}'">
                                </div>
                                <div class="p-4">
                                    <h4>${descubridor.nombre}</h4>
                                    <p><strong>País:</strong> ${pais}</p>
                                    <button type="button" class="mt-3 btn btn-primary" data-bs-toggle="modal" data-bs-target="#descubridorDetailsModal" onclick="loadDescubridorDetails(${descubridor.id})">
                                        Ver Detalles
                                    </button>
                                </div>
                            </div>
                        </div>`;
                    listaDescubridores.insertAdjacentHTML('beforeend', cardHtml);
                });
            } else {
                listaDescubridores.innerHTML = '<p class="text-center">No se encontraron descubridores.</p>';
            }
        }

        function loadDescubridorDetails(id) {
            fetch(`${baseUrl}/admin/descubridores/${id}`)
                .then(response => response.json())
                .then(data => {
                    const pais = data.pais ? data.pais.nombre : 'N/A';
                    document.getElementById('descubridorDetailsContent').innerHTML = `
                        <div class="text-center">
                            <img src="${data.foto ? `${baseUrl}/assets/img/descubridores/${data.foto}` : defaultImagePath}" alt="Imagen de ${data.nombre}" class="mb-3 img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;" onerror="this.src='${defaultImagePath}'">
                        </div>
                        <p><strong>Nombre:</strong> ${data.nombre}</p>
                        <p><strong>País:</strong> ${pais}</p>
                        <p><strong>Lugar de Nacimiento:</strong> ${data.lugar_nacimiento || 'N/A'}</p>
                        <p><strong>Biografía:</strong> ${data.biografia || 'N/A'}</p>
                        <p><strong>Expediciones:</strong> ${data.expediciones || 'N/A'}</p>
                    `;
                })
                .catch(error => {
                    console.error('Error al cargar detalles:', error);
                    document.getElementById('descubridorDetailsContent').innerHTML = `<p>Error al cargar detalles: ${error.message}</p>`;
                });
        }

        window.loadDescubridorDetails = loadDescubridorDetails;

        buscarDescubridorInput.addEventListener('input', () => {
            const query = buscarDescubridorInput.value.trim();
            fetchDescubridores(query);
        });

        fetchDescubridores();
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