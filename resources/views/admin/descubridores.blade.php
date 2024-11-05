@extends('admin.layouts.menu-layouts')

@section('content')
<main class="mt-3" style="margin-left: 20px; margin-right: 20px;">
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0 h5" style="color: #2E7D32;">Lista de Descubridores</h2>
        </div>
        <div class="card-body">
            <!-- Barra de búsqueda y botón para agregar -->
            <div class="mb-3 row">
                <div class="col-10 col-md-11">
                    <input type="text" id="buscarDescubridor" class="form-control border-success" placeholder="Buscar descubridor..." style="border-color: #2E7D32;">
                </div>
                <div class="col-2 col-md-1">
                    <button class="btn btn-outline-success w-100" data-bs-toggle="modal" data-bs-target="#addDiscovererModal">
                        <i class="fas fa-plus" style="color: #2E7D32;"></i>
                    </button>
                </div>
            </div>

            <!-- Lista de Descubridores -->
            <div class="list-group" id="listaDescubridores">
                @foreach ($descubridores as $descubridor)
                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center flex-column flex-md-row">

                </div>
                @endforeach
            </div>
        </div>
    </div>
</main>

<!-- Modal para agregar descubridor -->
<div class="modal fade" id="addDiscovererModal" tabindex="-1" aria-labelledby="addDiscovererModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDiscovererModalLabel" style="color: #2E7D32;">Agregar Descubridor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('descubridores.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre" class="form-label" style="color: #2E7D32;">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del descubridor">
                    </div>
                    <div class="mb-3">
                        <label for="pais" class="form-label" style="color: #2E7D32;">País</label>
                        <select class="form-control" id="pais" name="pais_id">
                            @foreach ($paises as $pais)
                                <option value="{{ $pais->id }}">{{ $pais->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="lugarNacimiento" class="form-label" style="color: #2E7D32;">Lugar de Nacimiento</label>
                        <input type="text" class="form-control" id="lugarNacimiento" name="lugar_nacimiento" placeholder="Lugar de nacimiento">
                    </div>
                    <div class="mb-3">
                        <label for="expediciones" class="form-label" style="color: #2E7D32;">Expediciones</label>
                        <textarea class="form-control" id="expediciones" name="expediciones" rows="3" placeholder="Expediciones realizadas"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="biografia" class="form-label" style="color: #2E7D32;">Biografía</label>
                        <textarea class="form-control" id="biografia" name="biografia" rows="3" placeholder="Biografía del descubridor"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label" style="color: #2E7D32;">Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto">
                    </div>
                    <button type="submit" class="btn btn-success">Agregar Descubridor</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para eliminar descubridor -->
<div class="modal fade" id="deleteDiscovererModal" tabindex="-1" aria-labelledby="deleteDiscovererModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteDiscovererModalLabel" style="color: #2E7D32;">Eliminar Descubridor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="deleteDiscovererContent" style="color: #2E7D32;">
                <!-- Contenido se actualizará dinámicamente -->
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver detalles del descubridor -->
<div class="modal fade" id="viewDiscovererModal" tabindex="-1" aria-labelledby="viewDiscovererModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewDiscovererModalLabel" style="color: #2E7D32;">Detalles del Descubridor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewDiscovererContent" style="color: #2E7D32;">
                <!-- Contenido se actualizará dinámicamente -->
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar descubridor -->
<div class="modal fade" id="editDiscovererModal" tabindex="-1" aria-labelledby="editDiscovererModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDiscovererModalLabel" style="color: #2E7D32;">Editar Descubridor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="editDiscovererContent" style="color: #2E7D32;">
                <!-- Contenido se actualizará dinámicamente -->
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
    const buscarDescubridorInput = document.getElementById('buscarDescubridor');
    const listaDescubridores = document.getElementById('listaDescubridores');
    const searchUrl = "{{ route('descubridores.search') }}"; // URL para la búsqueda

    function fetchDescubridores(query) {
        const url = `${searchUrl}?query=${encodeURIComponent(query)}`;

        fetch(url)
            .then(response => {
                if (!response.ok) throw new Error('Error en la red al buscar descubridores.');
                return response.json();
            })
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
                const fotoPath = descubridor.foto ? `{{ asset('assets/img/descubridores') }}/${descubridor.foto}` : '{{ asset('assets/img/default.jpg') }}';
                const descubridorItem = document.createElement('div');
                descubridorItem.className = 'list-group-item list-group-item-action d-flex justify-content-between align-items-center flex-column flex-md-row';

                descubridorItem.innerHTML = `
                    <div class="d-flex flex-column flex-md-row align-items-center">
                        <img src="${fotoPath}" alt="Imagen de ${descubridor.nombre}" class="user-img rounded-circle me-3" style="width: 100px; height: 100px; object-fit: cover;">
                        <div>
                            <h5 class="mb-1">${descubridor.nombre}</h5>
                            <p class="mb-1"><strong>País:</strong> ${descubridor.pais ? descubridor.pais.nombre : 'N/A'}</p>
                            <p class="mb-1"><strong>Lugar de Nacimiento:</strong> ${descubridor.lugar_nacimiento}</p>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-outline-success btn-sm me-1" data-bs-toggle="modal" data-bs-target="#viewDiscovererModal" onclick="loadDiscovererDetails(${descubridor.id})">
                            <i class="fas fa-search"></i>
                        </button>
                        <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editDiscovererModal" onclick="loadDiscovererEditForm(${descubridor.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteDiscovererModal" onclick="loadDiscovererDeleteConfirmation(${descubridor.id}, '${descubridor.nombre}')">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                `;
                listaDescubridores.appendChild(descubridorItem);
            });
        } else {
            listaDescubridores.innerHTML = '<p class="text-center">No se encontraron descubridores.</p>';
        }
    }

    buscarDescubridorInput.addEventListener('input', () => {
        const query = buscarDescubridorInput.value.trim();
        fetchDescubridores(query);
    });

    fetchDescubridores('');
});
const BASE_URL = "{{ url('') }}";
function loadDiscovererDetails(id) {
    fetch(`${BASE_URL}/admin/descubridores/${id}`)
        .then(response => {
            if (!response.ok) throw new Error('No se pudo cargar los detalles del descubridor.');
            return response.json();
        })
        .then(data => {
            document.getElementById('viewDiscovererContent').innerHTML = `
                <div class="text-center">
                    <img src="${data.foto ? `${BASE_URL}/assets/img/descubridores/${data.foto}` : `${BASE_URL}/assets/img/default.jpg`}" alt="Imagen de ${data.nombre}" class="mb-3 img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                </div>
                <p><strong>Nombre:</strong> ${data.nombre}</p>
                <p><strong>País:</strong> ${data.pais?.nombre ?? 'N/A'}</p>
                <p><strong>Lugar de Nacimiento:</strong> ${data.lugar_nacimiento}</p>
                <p><strong>Expediciones:</strong> ${data.expediciones}</p>
                <p><strong>Biografía:</strong> ${data.biografia}</p>
            `;
        })
        .catch(error => {
            console.error('Error al cargar detalles:', error);
            document.getElementById('viewDiscovererContent').innerHTML = `<p>Error al cargar detalles: ${error.message}</p>`;
        });
}

function loadDiscovererEditForm(id) {
    fetch(`${BASE_URL}/admin/descubridores/${id}/edit`)
        .then(response => {
            if (!response.ok) throw new Error('No se pudo cargar el formulario de edición.');
            return response.json();
        })
        .then(data => {
            document.getElementById('editDiscovererContent').innerHTML = `
                <form action="${BASE_URL}/admin/descubridores/${id}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3 text-center">
                        <img src="${data.descubridor.foto ? `${BASE_URL}/assets/img/descubridores/${data.descubridor.foto}` : `${BASE_URL}/assets/img/default.jpg`}" alt="Imagen de ${data.descubridor.nombre}" class="mb-3 img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <div class="mb-3">
                        <label for="editNombre" class="form-label" style="color: #2E7D32;">Nombre</label>
                        <input type="text" class="form-control" id="editNombre" name="nombre" value="${data.descubridor.nombre}">
                    </div>
                    <div class="mb-3">
                        <label for="editPais" class="form-label" style="color: #2E7D32;">País</label>
                        <select class="form-control" id="editPais" name="pais_id">
                            ${data.paises.map(pais => `
                                <option value="${pais.id}" ${data.descubridor.pais_id === pais.id ? 'selected' : ''}>${pais.nombre}</option>
                            `).join('')}
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editLugarNacimiento" class="form-label" style="color: #2E7D32;">Lugar de Nacimiento</label>
                        <input type="text" class="form-control" id="editLugarNacimiento" name="lugar_nacimiento" value="${data.descubridor.lugar_nacimiento}">
                    </div>
                    <div class="mb-3">
                        <label for="editExpediciones" class="form-label" style="color: #2E7D32;">Expediciones</label>
                        <textarea class="form-control" id="editExpediciones" name="expediciones" rows="3">${data.descubridor.expediciones}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editBiografia" class="form-label" style="color: #2E7D32;">Biografía</label>
                        <textarea class="form-control" id="editBiografia" name="biografia" rows="3">${data.descubridor.biografia}</textarea>
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
            document.getElementById('editDiscovererContent').innerHTML = `<p>Error al cargar el formulario de edición: ${error.message}</p>`;
        });
}




function loadDiscovererDeleteConfirmation(id, name) {
    document.getElementById('deleteDiscovererContent').innerHTML = `
        <p>¿Estás seguro de que deseas eliminar a ${name}?</p>
        <form action="${BASE_URL}/admin/descubridores/${id}" method="POST">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
    `;
}



</script>

@endsection
