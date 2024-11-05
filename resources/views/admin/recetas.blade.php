@extends('admin.layouts.menu-layouts')

@section('content')
<main class="mt-3" style="margin-left: 20px; margin-right: 20px;">
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0 h5" style="color: #2E7D32;">Lista de Recetas</h2>
        </div>
        <div class="card-body">
            <!-- Barra de búsqueda y botón para agregar -->
            <div class="mb-3 row">
                <div class="col-10 col-md-11">
                    <input type="text" id="buscarReceta" class="form-control border-success" placeholder="Buscar receta..." style="border-color: #2E7D32;">
                </div>
                <div class="col-2 col-md-1">
                    <button class="btn btn-outline-success w-100" data-bs-toggle="modal" data-bs-target="#addRecipeModal">
                        <i class="fas fa-plus" style="color: #2E7D32;"></i>
                    </button>
                </div>
            </div>

            <!-- Lista de Recetas -->
            <div class="list-group" id="listaRecetas">
                <!-- Recetas se cargarán dinámicamente aquí -->
            </div>
        </div>
    </div>
</main>

<!-- Modal para agregar receta -->
<div class="modal fade" id="addRecipeModal" tabindex="-1" aria-labelledby="addRecipeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRecipeModalLabel" style="color: #2E7D32;">Agregar Receta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('recetas.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre" class="form-label" style="color: #2E7D32;">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de la receta">
                    </div>
                    <div class="mb-3">
                        <label for="ingredientes" class="form-label" style="color: #2E7D32;">Ingredientes</label>
                        <textarea class="form-control" id="ingredientes" name="ingredientes" rows="3" placeholder="Lista de ingredientes"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="preparacion" class="form-label" style="color: #2E7D32;">Preparación</label>
                        <textarea class="form-control" id="preparacion" name="preparacion" rows="3" placeholder="Instrucciones de preparación"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tiempoPreparacion" class="form-label" style="color: #2E7D32;">Tiempo de Preparación (minutos)</label>
                        <input type="number" class="form-control" id="tiempoPreparacion" name="tiempo_preparacion" placeholder="Tiempo en minutos">
                    </div>
                    <div class="mb-3">
                        <label for="dificultad" class="form-label" style="color: #2E7D32;">Dificultad</label>
                        <select class="form-control" id="dificultad" name="dificultad_id">
                            @foreach ($dificultades as $dificultad)
                                <option value="{{ $dificultad->id }}">{{ $dificultad->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="planta" class="form-label" style="color: #2E7D32;">Planta</label>
                        <select class="form-control" id="planta" name="planta_id">
                            @foreach ($plantas as $planta)
                                <option value="{{ $planta->id }}">{{ $planta->nombre_comun }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label" style="color: #2E7D32;">Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto">
                    </div>
                    <button type="submit" class="btn btn-success">Agregar Receta</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver detalles de la receta -->
<div class="modal fade" id="viewRecipeModal" tabindex="-1" aria-labelledby="viewRecipeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewRecipeModalLabel" style="color: #2E7D32;">Detalles de la Receta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewRecipeContent" style="color: #2E7D32;">
                <!-- Detalles de receta se cargarán dinámicamente -->
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar receta -->
<div class="modal fade" id="editRecipeModal" tabindex="-1" aria-labelledby="editRecipeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRecipeModalLabel" style="color: #2E7D32;">Editar Receta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="editRecipeContent" style="color: #2E7D32;">
                <!-- Formulario de edición se cargará dinámicamente -->
            </div>
        </div>
    </div>
</div>

<!-- Modal para eliminar receta -->
<div class="modal fade" id="deleteRecipeModal" tabindex="-1" aria-labelledby="deleteRecipeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteRecipeModalLabel" style="color: #2E7D32;">Eliminar Receta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="deleteRecipeContent" style="color: #2E7D32;">
                <!-- Confirmación de eliminación se cargará dinámicamente -->
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const buscarRecetaInput = document.getElementById('buscarReceta');
        const listaRecetas = document.getElementById('listaRecetas');
        const searchUrl = "{{ route('recetas.search') }}";

        function fetchRecetas(query) {
            const url = `${searchUrl}?query=${encodeURIComponent(query)}`;
            fetch(url)
                .then(response => response.json())
                .then(data => renderRecetas(data))
                .catch(error => console.error('Error al cargar recetas:', error));
        }

        function renderRecetas(recetas) {
    listaRecetas.innerHTML = '';

    if (recetas.length > 0) {
        recetas.forEach(receta => {
            const fotoPath = receta.foto ? `{{ asset('assets/img/recetas') }}/${receta.foto}` : '{{ asset('assets/img/default.jpg') }}';
            const dificultad = receta.dificultad ? receta.dificultad.nombre : 'No especificada';
            const planta = receta.planta && receta.planta.nombre_comun ? receta.planta.nombre_comun : 'No especificada';

            const recetaItem = document.createElement('div');
            recetaItem.className = 'list-group-item list-group-item-action d-flex justify-content-between align-items-center flex-column flex-md-row';

            recetaItem.innerHTML = `
                <div class="d-flex flex-column flex-md-row align-items-center">
                    <img src="${fotoPath}" alt="Imagen de ${receta.nombre}" class="user-img rounded-circle me-3" style="width: 100px; height: 100px; object-fit: cover;">
                    <div>
                        <h5 class="mb-1">${receta.nombre}</h5>
                        <p class="mb-1"><strong>Dificultad:</strong> ${dificultad}</p>
                        <p class="mb-1"><strong>Planta:</strong> ${planta}</p>
                    </div>
                </div>
                <div>
                    <button class="btn btn-outline-success btn-sm me-1" data-bs-toggle="modal" data-bs-target="#viewRecipeModal" onclick="loadRecetaDetails(${receta.id})">
                        <i class="fas fa-search"></i>
                    </button>
                    <button class="btn btn-outline-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editRecipeModal" onclick="loadRecetaEditForm(${receta.id})">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteRecipeModal" onclick="loadRecetaDeleteConfirmation(${receta.id}, '${receta.nombre}')">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            `;

            listaRecetas.appendChild(recetaItem);
        });
    } else {
        listaRecetas.innerHTML = '<p class="text-center">No se encontraron recetas.</p>';
    }
}


        buscarRecetaInput.addEventListener('input', () => {
            const query = buscarRecetaInput.value.trim();
            fetchRecetas(query);
        });

        fetchRecetas('');
    });

    function loadRecetaDetails(id) {
    const BASE_URL = "{{ url('') }}"; // Asegúrate de que esta URL esté definida

    fetch(`${BASE_URL}/admin/recetas/${id}`)
        .then(response => response.json())
        .then(data => {
            const plantaNombre = data.planta && data.planta.nombre_comun ? data.planta.nombre_comun : 'No especificada';

            document.getElementById('viewRecipeContent').innerHTML = `
                <div class="text-center">
                    <img src="${data.foto ? `${BASE_URL}/assets/img/recetas/${data.foto}` : `${BASE_URL}/assets/img/default.jpg`}"
                        alt="Imagen de ${data.nombre}" class="mb-3 img-fluid rounded-circle"
                        style="width: 150px; height: 150px; object-fit: cover;">
                </div>
                <p><strong>Nombre:</strong> ${data.nombre}</p>
                <p><strong>Ingredientes:</strong> ${data.ingredientes}</p>
                <p><strong>Preparación:</strong> ${data.preparacion}</p>
                <p><strong>Tiempo de Preparación:</strong> ${data.tiempo_preparacion || 'No especificado'} minutos</p>
                <p><strong>Dificultad:</strong> ${data.dificultad ? data.dificultad.nombre : 'No especificada'}</p>
                <p><strong>Planta:</strong> ${plantaNombre}</p>
            `;
        })
        .catch(error => {
            console.error('Error al cargar detalles:', error);
            document.getElementById('viewRecipeContent').innerHTML = `<p>Error al cargar detalles: ${error.message}</p>`;
        });
}


    function loadRecetaEditForm(id) {
    const BASE_URL = "{{ url('') }}"; // Asegúrate de que esta URL esté definida

    fetch(`${BASE_URL}/admin/recetas/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            // Verificar si la receta y las listas se han cargado correctamente
            if (data.receta && data.dificultades && data.plantas) {
                document.getElementById('editRecipeContent').innerHTML = `
                    <form action="${BASE_URL}/admin/recetas/${id}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3 text-center">
                            <img src="${data.receta.foto ? `${BASE_URL}/assets/img/recetas/${data.receta.foto}` : `${BASE_URL}/assets/img/default.jpg`}"
                                alt="Imagen de ${data.receta.nombre}" class="mb-3 img-fluid rounded-circle"
                                style="width: 150px; height: 150px; object-fit: cover;">
                        </div>

                        <div class="mb-3">
                            <label for="editNombre" class="form-label" style="color: #2E7D32;">Nombre</label>
                            <input type="text" class="form-control" id="editNombre" name="nombre" value="${data.receta.nombre}">
                        </div>

                        <div class="mb-3">
                            <label for="editIngredientes" class="form-label" style="color: #2E7D32;">Ingredientes</label>
                            <textarea class="form-control" id="editIngredientes" name="ingredientes" rows="3">${data.receta.ingredientes}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="editPreparacion" class="form-label" style="color: #2E7D32;">Preparación</label>
                            <textarea class="form-control" id="editPreparacion" name="preparacion" rows="3">${data.receta.preparacion}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="editTiempoPreparacion" class="form-label" style="color: #2E7D32;">Tiempo de Preparación</label>
                            <input type="number" class="form-control" id="editTiempoPreparacion" name="tiempo_preparacion" value="${data.receta.tiempo_preparacion || ''}">
                        </div>

                        <div class="mb-3">
                            <label for="editDificultad" class="form-label" style="color: #2E7D32;">Dificultad</label>
                            <select class="form-control" id="editDificultad" name="dificultad_id">
                                ${data.dificultades.map(dificultad => `
                                    <option value="${dificultad.id}" ${data.receta.dificultad_id === dificultad.id ? 'selected' : ''}>${dificultad.nombre}</option>
                                `).join('')}
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="editPlanta" class="form-label" style="color: #2E7D32;">Planta</label>
                            <select class="form-control" id="editPlanta" name="planta_id">
                                ${data.plantas.map(planta => `
                                    <option value="${planta.id}" ${data.receta.planta_id === planta.id ? 'selected' : ''}>${planta.nombre_comun}</option>
                                `).join('')}
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="editFoto" class="form-label" style="color: #2E7D32;">Actualizar Foto</label>
                            <input type="file" class="form-control" id="editFoto" name="foto">
                        </div>

                        <button type="submit" class="btn btn-success">Guardar cambios</button>
                    </form>
                `;
            } else {
                document.getElementById('editRecipeContent').innerHTML = '<p>Error al cargar datos para la receta.</p>';
            }
        })
        .catch(error => {
            console.error('Error al cargar formulario de edición:', error);
            document.getElementById('editRecipeContent').innerHTML = `<p>Error al cargar el formulario de edición: ${error.message}</p>`;
        });
}



    function loadRecetaDeleteConfirmation(id, name) {
        document.getElementById('deleteRecipeContent').innerHTML = `
            <p>¿Estás seguro de que deseas eliminar la receta "${name}"?</p>
            <form action="{{ url('/admin/recetas') }}/${id}" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
        `;
    }
</script>
@endsection
