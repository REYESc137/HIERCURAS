@extends('admin.layouts.menu-layouts')

@section('content')
<main class="mt-3" style="margin-left: 20px; margin-right: 20px;">
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0 h5" style="color: #2E7D32;">Lista de Plantas</h2>
        </div>
        <div class="card-body">
            <!-- Barra de búsqueda y botón para agregar -->
            <div class="mb-3 row">
                <div class="col-10 col-md-11">
                    <input type="text" id="buscarPlanta" class="form-control border-success" placeholder="Buscar planta..." style="border-color: #2E7D32;">
                </div>
                <div class="col-2 col-md-1">
                    <button class="btn btn-outline-success w-100" data-bs-toggle="modal" data-bs-target="#addPlantaModal">
                        <i class="fas fa-plus" style="color: #2E7D32;"></i>
                    </button>
                </div>
            </div>

            <!-- Lista de Plantas -->
            <div class="list-group" id="listaPlantas">
                @foreach ($plantas as $planta)
                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center flex-column flex-md-row">
                    <!-- Contenido dinámico de cada planta se generará en el script -->
                </div>
                @endforeach
            </div>
        </div>
    </div>
</main>

<!-- Modal para agregar planta -->
<div class="modal fade" id="addPlantaModal" tabindex="-1" aria-labelledby="addPlantaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPlantaModalLabel" style="color: #2E7D32;">Agregar Planta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('plantas.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre_comun" class="form-label" style="color: #2E7D32;">Nombre Común</label>
                        <input type="text" class="form-control" id="nombre_comun" name="nombre_comun" placeholder="Nombre común de la planta">
                    </div>
                    <div class="mb-3">
                        <label for="nombre_cientifico" class="form-label" style="color: #2E7D32;">Nombre Científico</label>
                        <input type="text" class="form-control" id="nombre_cientifico" name="nombre_cientifico" placeholder="Nombre científico de la planta">
                    </div>
                    <div class="mb-3">
                        <label for="editOtrosNombres" class="form-label" style="color: #2E7D32;">Otros Nombres</label>
                        <input type="text" class="form-control" id="editOtrosNombres" name="otros_nombres" placeholder="Otros nombres de la planta">
                    </div>
                    <div class="mb-3">
                        <label for="familia" class="form-label" style="color: #2E7D32;">Familia</label>
                        <select class="form-control" id="familia" name="familia_id">
                            @foreach ($familias as $familia)
                                <option value="{{ $familia->id }}">{{ $familia->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="lugar_origen" class="form-label" style="color: #2E7D32;">Lugar de Origen</label>
                        <select class="form-control" id="lugar_origen" name="lugar_origen">
                            @foreach ($paises as $pais)
                                <option value="{{ $pais->id }}">{{ $pais->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="descubridor" class="form-label" style="color: #2E7D32;">Descubridor</label>
                        <select class="form-control" id="descubridor" name="cientifico_descubridor_id">
                            @foreach ($descubridores as $descubridor)
                                <option value="{{ $descubridor->id }}">{{ $descubridor->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="especiesRelacionadas" class="form-label" style="color: #2E7D32;">Especies Relacionadas</label>
                        <select class="form-control" id="especiesRelacionadas" name="especies_relacionadas_id">
                            @foreach ($especiesRelacionadas as $especie)
                                <option value="{{ $especie->id }}">{{ $especie->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editDescripcion" class="form-label" style="color: #2E7D32;">Descripción</label>
                        <textarea class="form-control" id="Descripcion" name="descripcion" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="uso" class="form-label" style="color: #2E7D32;">Uso</label>
                        <textarea class="form-control" id="uso" name="uso" rows="3" placeholder="Uso de la planta"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label" style="color: #2E7D32;">Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto">
                    </div>
                    <button type="submit" class="btn btn-success">Agregar Planta</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver detalles de la planta -->
<div class="modal fade" id="viewPlantaModal" tabindex="-1" aria-labelledby="viewPlantaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewPlantaModalLabel" style="color: #2E7D32;">Detalles de la Planta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewPlantaContent" style="color: #2E7D32;">
                <!-- Contenido se actualizará dinámicamente -->
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar planta -->
<div class="modal fade" id="editPlantaModal" tabindex="-1" aria-labelledby="editPlantaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPlantaModalLabel" style="color: #2E7D32;">Editar Planta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="editPlantaContent" style="color: #2E7D32;">
                <!-- Contenido se actualizará dinámicamente -->
            </div>
        </div>
    </div>
</div>

<!-- Modal para eliminar planta -->
<div class="modal fade" id="deletePlantaModal" tabindex="-1" aria-labelledby="deletePlantaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePlantaModalLabel" style="color: #2E7D32;">Eliminar Planta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="deletePlantaContent" style="color: #2E7D32;">
                <!-- Contenido se actualizará dinámicamente -->
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
    const buscarPlantaInput = document.getElementById('buscarPlanta');
    const listaPlantas = document.getElementById('listaPlantas');
    const searchUrl = "{{ route('plantas.search') }}";


    function fetchPlantas(query) {
        const url = `${searchUrl}?query=${encodeURIComponent(query)}`;

        fetch(url)
            .then(response => response.json())
            .then(data => renderPlantas(data))
            .catch(error => {
                console.error('Error al cargar plantas:', error);
                listaPlantas.innerHTML = '<p class="text-center">Hubo un error al buscar las plantas.</p>';
            });
    }

    function renderPlantas(plantas) {
    listaPlantas.innerHTML = '';

    if (plantas.length > 0) {
        plantas.forEach(planta => {
            console.log(planta.lugar_origen); // Debería mostrar el objeto { id: 2, nombre: "Estados Unidos", ... }

            const fotoPath = planta.foto ? `{{ asset('assets/img/plantas') }}/${planta.foto}` : '{{ asset('assets/img/default.jpg') }}';

            // Acceso seguro a lugar de origen y familia
            const lugarOrigen = planta.lugar_origen && planta.lugar_origen.nombre ? planta.lugar_origen.nombre : 'Sin lugar de origen definido';
            const especieRelacionada = planta.especies_relacionadas && planta.especies_relacionadas.nombre ? planta.especies_relacionadas.nombre : 'Especie no definida';
            const familia = planta.familia && planta.familia.nombre ? planta.familia.nombre : 'Familia no definida';

            const plantaItem = document.createElement('div');
            plantaItem.className = 'list-group-item list-group-item-action d-flex justify-content-between align-items-center flex-column flex-md-row';

            plantaItem.innerHTML = `
                <div class="d-flex flex-column flex-md-row align-items-center">
                    <img src="${fotoPath}" alt="Imagen de ${planta.nombre_comun}" class="user-img rounded-circle me-3" style="width: 100px; height: 100px; object-fit: cover;">
                    <div>
                        <h5 class="mb-1">${planta.nombre_comun}</h5>
                        <p class="mb-1"><strong>Familia:</strong> ${familia}</p>
                        <p class="mb-1"><strong>Lugar de Origen:</strong> ${lugarOrigen}</p>
                        <p class="mb-1"><strong>Especie Relacionada:</strong> ${especieRelacionada}</p>
                    </div>
                </div>
                <div>
                    <button class="btn btn-outline-success btn-sm me-1" data-bs-toggle="modal" data-bs-target="#viewPlantaModal" onclick="loadPlantaDetails(${planta.id})">
                        <i class="fas fa-search"></i>
                    </button>
                    <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPlantaModal" onclick="loadPlantaEditForm(${planta.id})">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletePlantaModal" onclick="loadPlantaDeleteConfirmation(${planta.id}, '${planta.nombre_comun}')">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            `;

            listaPlantas.appendChild(plantaItem);
        });
    } else {
        listaPlantas.innerHTML = '<p class="text-center">No se encontraron plantas.</p>';
    }
}











    // Función de búsqueda al escribir en el campo de búsqueda
    buscarPlantaInput.addEventListener('input', () => {
        const query = buscarPlantaInput.value.trim();
        fetchPlantas(query);
    });

    fetchPlantas('');  // Llama a la función de carga inicial de plantas
});


    const BASE_URL = "{{ url('') }}";

    function loadPlantaDetails(id) {
    fetch(`${BASE_URL}/admin/plantas/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('viewPlantaContent').innerHTML = `
                <div class="text-center">
                    <img src="${data.foto ? `${BASE_URL}/assets/img/plantas/${data.foto}` : `${BASE_URL}/assets/img/default.jpg`}" alt="Imagen de ${data.nombre_comun}" class="mb-3 img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
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
            document.getElementById('viewPlantaContent').innerHTML = `<p>Error al cargar detalles: ${error.message}</p>`;
        });
}



function loadPlantaEditForm(id) {
    fetch(`${BASE_URL}/admin/plantas/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('editPlantaContent').innerHTML = `
                <form action="${BASE_URL}/admin/plantas/${id}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3 text-center">
                        <img src="${data.planta.foto ? `${BASE_URL}/assets/img/plantas/${data.planta.foto}` : `${BASE_URL}/assets/img/default.jpg`}" alt="Imagen de ${data.planta.nombre_comun}" class="mb-3 img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <div class="mb-3">
                        <label for="editNombreComun" class="form-label" style="color: #2E7D32;">Nombre Común</label>
                        <input type="text" class="form-control" id="editNombreComun" name="nombre_comun" value="${data.planta.nombre_comun}">
                    </div>
                    <div class="mb-3">
                        <label for="editNombreCientifico" class="form-label" style="color: #2E7D32;">Nombre Científico</label>
                        <input type="text" class="form-control" id="editNombreCientifico" name="nombre_cientifico" value="${data.planta.nombre_cientifico}">
                    </div>
                    <div class="mb-3">
                        <label for="editOtrosNombres" class="form-label" style="color: #2E7D32;">Otros Nombres</label>
                        <input type="text" class="form-control" id="editOtrosNombres" name="otros_nombres" value="${data.planta.otros_nombres || ''}">
                    </div>
                    <div class="mb-3">
                        <label for="editFamilia" class="form-label" style="color: #2E7D32;">Familia</label>
                        <select class="form-control" id="editFamilia" name="familia_id">
                            ${data.familias.map(familia => `
                                <option value="${familia.id}" ${data.planta.familia_id === familia.id ? 'selected' : ''}>${familia.nombre}</option>
                            `).join('')}
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editLugarOrigen" class="form-label" style="color: #2E7D32;">Lugar de Origen</label>
                        <select class="form-control" id="editLugarOrigen" name="lugar_origen">
                            ${data.paises.map(pais => `
                                <option value="${pais.id}" ${data.planta.lugar_origen && data.planta.lugar_origen.id === pais.id ? 'selected' : ''}>${pais.nombre}</option>
                            `).join('')}
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editDescubridor" class="form-label" style="color: #2E7D32;">Descubridor</label>
                        <select class="form-control" id="editDescubridor" name="cientifico_descubridor_id">
                            ${data.descubridores.map(descubridor => `
                                <option value="${descubridor.id}" ${data.planta.cientifico_descubridor_id === descubridor.id ? 'selected' : ''}>${descubridor.nombre}</option>
                            `).join('')}
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editEspeciesRelacionadas" class="form-label" style="color: #2E7D32;">Especies Relacionadas</label>
                        <select class="form-control" id="editEspeciesRelacionadas" name="especies_relacionadas_id">
                            ${data.especiesRelacionadas.map(especie => `
                                <option value="${especie.id}" ${data.planta.especies_relacionadas_id === especie.id ? 'selected' : ''}>${especie.nombre}</option>
                            `).join('')}
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editDescripcion" class="form-label" style="color: #2E7D32;">Descripción</label>
                        <textarea class="form-control" id="editDescripcion" name="descripcion" rows="3">${data.planta.descripcion || ''}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editUso" class="form-label" style="color: #2E7D32;">Uso</label>
                        <textarea class="form-control" id="editUso" name="uso" rows="3">${data.planta.uso || ''}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editFoto" class="form-label" style="color: #2E7D32;">Actualizar Foto</label>
                        <input type="file" class="form-control" id="editFoto" name="foto">
                    </div>
                    <button type="submit" class="btn btn-success">Guardar cambios</button>
                </form>
            `;
        })
        .catch(error => {
            console.error('Error al cargar formulario de edición:', error);
            document.getElementById('editPlantaContent').innerHTML = `<p>Error al cargar el formulario de edición: ${error.message}</p>`;
        });
}



    function loadPlantaDeleteConfirmation(id, name) {
        document.getElementById('deletePlantaContent').innerHTML = `
            <p>¿Estás seguro de que deseas eliminar a ${name}?</p>
            <form action="${BASE_URL}/admin/plantas/${id}" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
        `;
    }
</script>

@endsection
