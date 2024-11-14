@extends('admin.layouts.menu-layouts')

@section('content')
<main class="mt-3" style="margin-left: 20px; margin-right: 20px;">
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0 h5" style="color: #2E7D32;">Lista de Usuarios</h2>
        </div>
        <div class="card-body">
            <!-- Barra de búsqueda y botón para agregar -->
            <div class="mb-3 row">
                <div class="col-10 col-md-11">
                    <input type="text" id="buscarUsuario" class="form-control border-success" placeholder="Buscar usuario..." style="border-color: #2E7D32;">
                </div>
                <div class="col-2 col-md-1">
                    <button class="btn btn-outline-success w-100" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fas fa-plus" style="color: #2E7D32;"></i>
                    </button>
                </div>
            </div>

            <!-- Lista de Usuarios -->
            <div class="list-group" id="listaUsuarios">
                @foreach ($users as $usuario)
                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center flex-column flex-md-row">
                    <!-- Lista de Usuarioscargada el el java -->
                </div>
                @endforeach
            </div>
        </div>
    </div>
</main>

<!-- Modal para agregar usuario -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel" style="color: #2E7D32;">Agregar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('usuarios.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label" style="color: #2E7D32;">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre del usuario">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label" style="color: #2E7D32;">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email del usuario">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label" style="color: #2E7D32;">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
                    </div>
                    <div class="mb-3">
                        <label for="tipo_usuario" class="form-label" style="color: #2E7D32;">Tipo de Usuario</label>
                        <select class="form-control" id="tipo_user_id" name="tipo_user_id">
                            @foreach ($tipoUsers as $rol)
                                <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                            @endforeach
                        </select>
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
                        <label for="foto" class="form-label" style="color: #2E7D32;">Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto">
                    </div>
                    <button type="submit" class="btn btn-success">Agregar Usuario</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para eliminar usuario -->
<!-- Modal para eliminar usuario -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel" style="color: #2E7D32;">Eliminar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="deleteUserContent" style="color: #2E7D32;">
                <!-- Contenido se actualizará dinámicamente -->
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver detalles del usuario -->
<div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewUserModalLabel" style="color: #2E7D32;">Detalles del Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewUserContent" style="color: #2E7D32;">
                <!-- Contenido dinámico -->
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar usuario -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel" style="color: #2E7D32;">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="editUserContent" style="color: #2E7D32;">
                <!-- Contenido dinámico -->
            </div>
        </div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', () => {
        const buscarUsuarioInput = document.getElementById('buscarUsuario');
        const listaUsuarios = document.getElementById('listaUsuarios');
        const searchUrl = "{{ route('usuarios.search') }}"; // URL para la búsqueda

        function fetchUsuarios(query) {
            const url = `${searchUrl}?query=${encodeURIComponent(query)}`;

            fetch(url)
                .then(response => {
                    if (!response.ok) throw new Error('Error en la red al buscar usuarios.');
                    return response.json();
                })
                .then(data => renderUsuarios(data))
                .catch(error => {
                    console.error('Error al cargar usuarios:', error);
                    listaUsuarios.innerHTML = '<p class="text-center">Hubo un error al buscar usuarios.</p>';
                });
        }

        function renderUsuarios(usuarios) {
            listaUsuarios.innerHTML = '';

            if (usuarios.length > 0) {
                usuarios.forEach(usuario => {
                    const fotoPath = usuario.foto ? `{{ asset('assets/img/users') }}/${usuario.foto}` : '{{ asset('assets/img/default.jpg') }}';
                    const usuarioItem = document.createElement('div');
                    usuarioItem.className = 'list-group-item list-group-item-action d-flex justify-content-between align-items-center flex-column flex-md-row';

                    usuarioItem.innerHTML = `
                        <div class="d-flex flex-column flex-md-row align-items-center">
                            <img src="${fotoPath}" alt="Foto de ${usuario.name}" class="user-img rounded-circle me-3" style="width: 100px; height: 100px; object-fit: cover;">
                            <div>
                                <h5 class="mb-1">${usuario.name}</h5>
                                <p class="mb-1"><strong>Email:</strong> ${usuario.email}</p>
                                <p class="mb-1"><strong>País:</strong> ${usuario.pais ? usuario.pais.nombre : 'N/A'}</p>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-outline-success btn-sm me-1" data-bs-toggle="modal" data-bs-target="#viewUserModal" onclick="verDetalles(${usuario.id})">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-outline-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editUserModal" onclick="editarUsuario(${usuario.id})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteUserModal" onclick="loadUserDeleteConfirmation(${usuario.id}, '${usuario.name}')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            </div>
                    `;

                    listaUsuarios.appendChild(usuarioItem);
                });
            } else {
                listaUsuarios.innerHTML = '<p class="text-center">No se encontraron usuarios.</p>';
            }
        }

        buscarUsuarioInput.addEventListener('input', () => {
            const query = buscarUsuarioInput.value.trim();
            fetchUsuarios(query);
        });

        fetchUsuarios('');
    });

    const BASE_URL = "{{ url('') }}";

    // Función para ver detalles del usuario
    // Función para ver detalles del usuario
// Función para ver detalles del usuario
function verDetalles(usuarioId) {
    fetch(`/admin/usuarios/${usuarioId}`)
        .then(response => response.json())
        .then(data => {
            console.log(data);  // Verificar la respuesta
            const usuario = data.user; // Asegúrate de que `data.user` contiene los datos del usuario
            const modalBody = document.getElementById('viewUserContent');
            modalBody.innerHTML = `
                <div class="mb-3"><strong>Nombre:</strong> ${usuario.name}</div>
                <div class="mb-3"><strong>Email:</strong> ${usuario.email}</div>
                <div class="mb-3"><strong>Tipo de usuario:</strong> ${data.tipoUser.nombre}</div>
                <div class="mb-3"><strong>País:</strong> ${data.pais ? data.pais.nombre : 'No especificado'}</div>
                <div class="mb-3">
                    <strong>Foto:</strong>
                    <img src="${usuario.foto ? '/assets/img/users/' + usuario.foto : '/assets/img/default.jpg'}" alt="Foto de usuario" style="width: 100px; height: 100px; object-fit: cover;">
                </div>
            `;
        })
        .catch(error => {
            console.error(error);
            alert('Hubo un problema al cargar los detalles del usuario.');
        });
}



// Función para editar usuario
// Función para editar usuario
function editarUsuario(usuarioId) {
    fetch(`/admin/usuarios/${usuarioId}/edit`)
        .then(response => response.json())
        .then(data => {
            console.log(data);  // Verificar la respuesta
            const usuario = data.user;
            const modalBody = document.getElementById('editUserContent');
            modalBody.innerHTML = `
                <form action="/admin/usuarios/${usuario.id}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" value="${usuario.name}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="${usuario.email}" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Nueva contraseña">
                    </div>
                    <div class="mb-3">
                        <label for="tipo_usuario" class="form-label">Tipo de Usuario</label>
                        <select class="form-control" id="tipo_user_id" name="tipo_user_id">
                            ${data.tipoUsers.map(tipo => `
                                <option value="${tipo.id}" ${tipo.id === usuario.tipo_user_id ? 'selected' : ''}>${tipo.nombre}</option>
                            `).join('')}
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="pais" class="form-label">País</label>
                        <select class="form-control" id="pais" name="pais_id">
                            ${data.paises.map(pais => `
                                <option value="${pais.id}" ${pais.id === usuario.pais_id ? 'selected' : ''}>${pais.nombre}</option>
                            `).join('')}
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto">
                    </div>
                    <button type="submit" class="btn btn-success">Guardar cambios</button>
                </form>
            `;
        })
        .catch(error => {
            console.error(error);
            alert('Hubo un problema al cargar los datos para editar el usuario.');
        });
}

function eliminarUsuario(id) {
    fetch(`/admin/usuarios/${id}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
    })
    .then(response => {
        if (response.ok) {
            // Redirigir o actualizar la página después de la eliminación exitosa
            alert('Usuario eliminado correctamente');
            window.location.reload();  // O actualiza la lista de usuarios de alguna otra forma
        } else {
            alert('Hubo un error al eliminar el usuario');
        }
    })
    .catch(error => {
        console.error('Error al eliminar el usuario:', error);
        alert('Hubo un problema al intentar eliminar el usuario');
    });
}


function loadUserDeleteConfirmation(id, name) {
        document.getElementById('deleteUserContent').innerHTML = `
            <p>¿Estás seguro de que deseas eliminar a ${name}?</p>
            <form action="${BASE_URL}/admin/usuarios/${id}" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
        `;
    }



</script>


@endsection
