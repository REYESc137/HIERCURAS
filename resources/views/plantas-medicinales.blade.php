@extends('layouts.plantas-medicinales_layouts')

@section('content')

<header class="relative" style="background-image: url('{{ asset('assets/img/Plantasmedicinales.jpg') }}'); background-size: cover; background-position: center center; background-color: rgba(0, 0, 0, 0.5); background-blend-mode: darken;">
    <div class="flex items-center justify-between h-48 px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h1 class="text-5xl font-bold text-white dark:text-gray-200">
            {{ __('Plantas Medicinales') }}
        </h1>
        <div class="input-group w-50">
            <input type="search" id="buscarPlantaMedicinal" class="p-3 form-control" placeholder="Buscar planta medicinal..." aria-describedby="search-icon-1">
            <span id="search-icon-1" class="p-3 input-group-text"><i class="fa fa-search"></i></span>
        </div>
    </div>
</header>

<main class="pt-0 mt-0">
    <div class="container py-5">
        <div class="row g-4" id="listaPlantasMedicinales">
            <!-- Aquí se insertarán dinámicamente las cards de cada planta medicinal -->
        </div>
    </div>
</main>

<div class="modal fade" id="plantDetailsModal" tabindex="-1" aria-labelledby="plantDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="plantDetailsModalLabel">Detalles de la Planta Medicinal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="plantDetailsContent">
                <!-- Contenido dinámico de los detalles de la planta -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<style>
    .plant-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
    const buscarPlantaInput = document.getElementById('buscarPlantaMedicinal');
    const listaPlantasMedicinales = document.getElementById('listaPlantasMedicinales');
    const searchUrl = "{{ route('plantas.search') }}";
    const baseUrl = "{{ url('') }}";
    const defaultImagePath = "{{ asset('assets/img/Hiercura_logo.png') }}"; // Imagen por defecto

    function fetchPlantas(query = '') {
        const url = `${searchUrl}?query=${encodeURIComponent(query)}`;

        fetch(url)
            .then(response => response.json())
            .then(data => renderPlantas(data))
            .catch(error => {
                console.error('Error al cargar plantas medicinales:', error);
                listaPlantasMedicinales.innerHTML = '<p class="text-center">Hubo un error al buscar las plantas medicinales.</p>';
            });
    }

    function renderPlantas(plantas) {
        listaPlantasMedicinales.innerHTML = '';

        if (plantas.length > 0) {
            plantas.forEach(planta => {
                const fotoPath = planta.foto ? `${baseUrl}/assets/img/plantas/${planta.foto}` : defaultImagePath;
                const familia = planta.familia ? planta.familia.nombre : 'Familia no definida';
                const cardHtml = `
                    <div class="col-md-6 col-lg-4">
                        <div class="rounded position-relative border border-secondary">
                            <div>
                                <img src="${fotoPath}" class="img-fluid plant-img" alt="Imagen de ${planta.nombre_comun}" onerror="this.src='${defaultImagePath}'">
                            </div>
                            <div class="p-4">
                                <h4>${planta.nombre_comun}</h4>
                                <p><strong>Nombre científico:</strong> <i>${planta.nombre_cientifico}</i></p>
                                <p><strong>Familia:</strong> ${familia}</p>
                                <button type="button" class="mt-3 btn btn-primary" data-bs-toggle="modal" data-bs-target="#plantDetailsModal" onclick="loadPlantDetails(${planta.id})">
                                    Ver Detalles
                                </button>
                            </div>
                        </div>
                    </div>`;
                listaPlantasMedicinales.insertAdjacentHTML('beforeend', cardHtml);
            });
        } else {
            listaPlantasMedicinales.innerHTML = '<p class="text-center">No se encontraron plantas medicinales.</p>';
        }
    }

    // Definir `loadPlantDetails` en el ámbito global
    function loadPlantDetails(id) {
        fetch(`${baseUrl}/admin/plantas/${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('plantDetailsContent').innerHTML = `
                    <div class="text-center">
                        <img src="${data.foto ? `${baseUrl}/assets/img/plantas/${data.foto}` : defaultImagePath}" alt="Imagen de ${data.nombre_comun}" class="mb-3 img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;" onerror="this.src='${defaultImagePath}'">
                    </div>
                    <p><strong>Nombre Común:</strong> ${data.nombre_comun}</p>
                    <p><strong>Nombre Científico:</strong> ${data.nombre_cientifico}</p>
                    <p><strong>Otros Nombres:</strong> ${data.otros_nombres || 'N/A'}</p>
                    <p><strong>Familia:</strong> ${data.familia ? data.familia.nombre : 'N/A'}</p>
                    <p><strong>Lugar de Origen:</strong> ${data.lugar_origen ? data.lugar_origen.nombre : 'N/A'}</p>
                    <p><strong>Descubridor:</strong> ${data.descubridor ? data.descubridor.nombre : 'N/A'}</p>
                    <p><strong>Especies Relacionadas:</strong> ${data.especies_relacionadas ? data.especies_relacionadas.nombre : 'N/A'}</p>
                    <p><strong>Uso:</strong> ${data.uso || 'N/A'}</p>
                    <p><strong>Descripción:</strong> ${data.descripcion || 'N/A'}</p>
                `;
            })
            .catch(error => {
                console.error('Error al cargar detalles:', error);
                document.getElementById('plantDetailsContent').innerHTML = `<p>Error al cargar detalles: ${error.message}</p>`;
            });
    }

    // Asignar la función `loadPlantDetails` al objeto global `window`
    window.loadPlantDetails = loadPlantDetails;

    buscarPlantaInput.addEventListener('input', () => {
        const query = buscarPlantaInput.value.trim();
        fetchPlantas(query);
    });

    fetchPlantas();
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