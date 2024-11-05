@extends('admin.layouts.menu-layouts')

@section('content')
<main class="mt-3" style="margin-left: 20px; margin-right: 20px;">
    <div class="card">
        <div class="card-header">
            <h2 class="h5 mb-0" style="color: #2E7D32;">Lista de Usuarios</h2>
        </div>
        <div class="card-body">
            <!-- Barra de búsqueda y botón para agregar -->
            <div class="row mb-3">
                <!-- Input de búsqueda ocupa todo el espacio -->
                <div class="col-10 col-md-11">
                    <input type="text" id="buscarUsuario" class="form-control border-success" placeholder="Buscar usuario..." style="border-color: #2E7D32;">
                </div>
                <!-- Botón de agregar (verde) que abre el modal para agregar -->
                <div class="col-2 col-md-1">
                    <button class="btn btn-outline-success w-100" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fas fa-plus" style="color: #2E7D32;"></i>
                    </button>
                </div>
            </div>

            <!-- Lista de Usuarios -->
            <div class="list-group" id="listaUsuarios">
                <!-- Usuario 1 -->
                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center flex-column flex-md-row">
                    <div class="d-flex flex-column flex-md-row align-items-center">
                        <img src="../img/user1.jpg" alt="User Image" class="user-img rounded-circle mb-3 mb-md-0 me-md-3" style="width: 100px; height: 100px; object-fit: cover;">
                        <div>
                            <h5 class="mb-1" style="color: #2E7D32;">Juan Pérez</h5>
                            <p class="mb-1"><strong>Email:</strong> juan.perez@gmail.com</p>
                            <p class="mb-1"><strong>País:</strong> México</p>
                            <p class="mb-1"><strong>Estado:</strong> Yucatán</p>
                        </div>
                    </div>
                    <div class="d-flex mt-2 mt-md-0">
                        <button class="btn btn-outline-success btn-sm me-1" data-bs-toggle="modal" data-bs-target="#viewUserModal">
                            <i class="fas fa-search"></i>
                        </button>
                        <button class="btn btn-outline-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editUserModal">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteUserModal">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>

                <!-- Usuario 2 -->
                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center flex-column flex-md-row">
                    <div class="d-flex flex-column flex-md-row align-items-center">
                        <img src="../img/user2.jpg" alt="User Image" class="user-img rounded-circle mb-3 mb-md-0 me-md-3" style="width: 100px; height: 100px; object-fit: cover;">
                        <div>
                            <h5 class="mb-1" style="color: #2E7D32;">María López</h5>
                            <p class="mb-1"><strong>Email:</strong> maria.lopez@gmail.com</p>
                            <p class="mb-1"><strong>País:</strong> Argentina</p>
                            <p class="mb-1"><strong>Estado:</strong> Buenos Aires</p>
                        </div>
                    </div>
                    <div class="d-flex mt-2 mt-md-0">
                        <button class="btn btn-outline-success btn-sm me-1" data-bs-toggle="modal" data-bs-target="#viewUserModal">
                            <i class="fas fa-search"></i>
                        </button>
                        <button class="btn btn-outline-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editUserModal">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteUserModal">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
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
                <form>
                    <div class="mb-3">
                        <label for="nombreUsuario" class="form-label" style="color: #2E7D32;">Nombre</label>
                        <input type="text" class="form-control" id="nombreUsuario" placeholder="Nombre del usuario">
                    </div>
                    <div class="mb-3">
                        <label for="emailUsuario" class="form-label" style="color: #2E7D32;">Email</label>
                        <input type="email" class="form-control" id="emailUsuario" placeholder="Email del usuario">
                    </div>
                    <div class="mb-3">
                        <label for="paisUsuario" class="form-label" style="color: #2E7D32;">País</label>
                        <input type="text" class="form-control" id="paisUsuario" placeholder="País de origen">
                    </div>
                    <div class="mb-3">
                        <label for="estadoUsuario" class="form-label" style="color: #2E7D32;">Estado</label>
                        <input type="text" class="form-control" id="estadoUsuario" placeholder="Estado de origen">
                    </div>
                    <div class="mb-3">
                        <label for="tipoUsuario" class="form-label" style="color: #2E7D32;">Tipo de Usuario</label>
                        <input type="text" class="form-control" id="tipoUsuario" placeholder="Tipo de usuario">
                    </div>
                </form>
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
            <div class="modal-body" style="color: #2E7D32;">
                <p><strong>Nombre:</strong> Juan Pérez</p>
                <p><strong>Email:</strong> juan.perez@gmail.com</p>
                <p><strong>País:</strong> México</p>
                <p><strong>Estado:</strong> Yucatán</p>
                <p><strong>Tipo de Usuario:</strong> Administrador</p>
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
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="editNombreUsuario" class="form-label" style="color: #2E7D32;">Nombre</label>
                        <input type="text" class="form-control" id="editNombreUsuario" value="Juan Pérez">
                    </div>
                    <div class="mb-3">
                        <label for="editEmailUsuario" class="form-label" style="color: #2E7D32;">Email</label>
                        <input type="email" class="form-control" id="editEmailUsuario" value="juan.perez@gmail.com">
                    </div>
                    <div class="mb-3">
                        <label for="editPaisUsuario" class="form-label" style="color: #2E7D32;">País</label>
                        <input type="text" class="form-control" id="editPaisUsuario" value="México">
                    </div>
                    <div class="mb-3">
                        <label for="editEstadoUsuario" class="form-label" style="color: #2E7D32;">Estado</label>
                        <input type="text" class="form-control" id="editEstadoUsuario" value="Yucatán">
                    </div>
                    <div class="mb-3">
                        <label for="editTipoUsuario" class="form-label" style="color: #2E7D32;">Tipo de Usuario</label>
                        <input type="text" class="form-control" id="editTipoUsuario" value="Administrador">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para eliminar usuario -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel" style="color: #2E7D32;">Eliminar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="color: #2E7D32;">
                <p>¿Estás seguro de que deseas eliminar este usuario?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger">Eliminar</button>
            </div>
        </div>
    </div>
</div>

@endsection
