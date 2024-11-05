<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>{{ config('app.name', 'Hiercura') }}</title>
    <link rel="icon" href="{{ asset('assets/img/Hiercura_logo.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/assets/vendor/css/theme-default.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />


    <style>
        /* Asegura que las tarjetas tengan el mismo tamaño */
        .fruite-item {
            overflow: hidden;
            height: 350px; /* Ajusta esta altura para que todas las tarjetas tengan el mismo tamaño */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .modal-dialog {
    margin: auto;
}

        /* Asegura que las imágenes mantengan un tamaño uniforme */
        .fruite-img img {
            width: 100%;
            height: 200px; /* Ajusta la altura de las imágenes */
            object-fit: cover; /* Mantiene las proporciones de la imagen */
            transition: transform 0.3s ease; /* Transición suave para el zoom */
        }

        /* Efecto de zoom en las imágenes cuando se pasa el mouse */
        .fruite-img img:hover {
            transform: scale(1.1); /* Efecto de zoom */
        }

        /* Para mantener el botón siempre en la parte inferior */
        .fruite-item .p-4 {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex-grow: 1;
        }

        /* Asegura que las tarjetas tengan márgenes uniformes */
        .fruite-item {
            margin-bottom: 20px;
        }
        /* Color del fondo del menú responsive */
    .layout-menu.menu-vertical {
        background-color: #4CAF50 !important; /* Ajusta este color al que deseas aplicar en el menú desplegable */
    }

    /* Asegurarse que las opciones del menú sean visibles */
    .menu-item .menu-link {
        color: #FFFFFF !important; /* Cambia el color del texto si es necesario */
    }

    /* Asegurarse que el fondo cubra toda el área del menú al desplegarse */
    .layout-menu-toggle {
        background-color: #4CAF50 !important;
    }

    /* Color del ícono de hamburguesa */
    .layout-menu-toggle .bx-menu {
        color: #FFFFFF !important;
    }

    /* Color de las opciones del menú desplegado en móviles */
    .menu-link {
        color: #FFFFFF !important;
    }
    /* Estilos para la sección de nombre y rol del usuario */
.user-info-header {
    background-color: #FFA500; /* Color naranja */
    padding: 10px;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Sombra */
}

/* Estilos para el menú desplegable */
.user-info-menu {
    background-color: #1B5E20; /* Fondo verde oscuro */
    padding: 15px;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
}

/* Estilos generales para el nombre del usuario */
.user-info-name {
    color: #FFFFFF;
    font-weight: bold;
    font-size: 16px;
}

/* Estilos para el rol (Admin, Usuario, etc.) */
.user-info-role {
    color: #CCCCCC;
    font-size: 12px;
}

/* Estilos para los íconos y los enlaces del menú */
.user-info-menu a {
    color: #FFFFFF;
    text-decoration: none;
    display: flex;
    align-items: center;
    padding: 10px 0;
}

.user-info-menu a:hover {
    text-decoration: underline;
}

    </style>

    <!-- Helpers -->
    <script src="{{ asset('assets/assets/vendor/js/helpers.js') }}"></script>
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.1/css/boxicons.min.css" />

    <!-- Config -->
    <script src="{{ asset('assets/assets/js/config.js') }}"></script>
    @if (Route::currentRouteName() == 'profile.edit' || Route::currentRouteName() == 'admin.profile.edit')
    <!-- Styles -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .navbar-dropdown.dropdown-user {
        position: relative;
        z-index: 1050; /* Ajusta el z-index para asegurarte de que el menú está por encima de otros elementos */
    }

    .layout-navbar {
        overflow: visible; /* Asegúrate de que el contenedor del navbar permita que los elementos flotantes se muestren */
    }

    .dropdown-menu-end {
        right: 0; /* Asegúrate de que el menú desplegable se alinee correctamente con el borde derecho */
        left: auto;
    }

    .avatar {
        position: relative;
        z-index: 1050;
    }

    .layout-page {
        overflow: visible; /* Permite que el contenido se desborde correctamente sin cortar el dropdown */
    }
    </style>

    @endif
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu" style="background-color: #4CAF50 !important;">
                <div class="app-brand demo">
                    <a href="{{ route('admin.index') }}" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <!-- Logo SVG -->
                            <svg width="25" viewBox="0 0 25 42" href="{{ asset('assets/img/Hiercura_logo.png') }}">
                                <!-- Logo content here -->
                            </svg>
                        </span>
                        <span class="app-brand-text demo menu-text fw-bolder ms-2" style="color: #FFFFFF !important;">Hiercura</span>
                    </a>
                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="align-middle bx bx-chevron-left bx-sm"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="py-1 menu-inner">
                    <!-- Inicio -->
                    <li class="menu-item">
                        <a href="{{ route('admin.index') }}" class="menu-link" style="color: #FFFFFF !important;">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div>Inicio</div>
                        </a>
                    </li>

                    <!-- Usuarios -->
                    <li class="menu-item">
                        <a href="{{ route('admin.usuarios') }}" class="menu-link" style="color: #FFFFFF !important;">
                            <i class="menu-icon tf-icons bx bx-user"></i>
                            <div>Usuarios</div>
                        </a>
                    </li>

                    <!-- Plantas -->
                    <li class="menu-item">
                        <a href="{{ route('admin.plantas') }}" class="menu-link" style="color: #FFFFFF !important;">
                            <i class="menu-icon tf-icons bx bx-leaf"></i>
                            <div>Plantas</div>
                        </a>
                    </li>

                    <!-- Descubridores -->
                    <li class="menu-item">
                        <a href="{{ route('admin.descubridores') }}" class="menu-link" style="color: #FFFFFF !important;">
                            <i class="menu-icon tf-icons bx bx-search-alt"></i>
                            <div>Descubridores</div>
                        </a>
                    </li>

                    <!-- Recetas -->
                    <li class="menu-item">
                        <a href="{{ route('admin.recetas') }}" class="menu-link" style="color: #FFFFFF !important;">
                            <i class="menu-icon tf-icons bx bx-book"></i>
                            <div>Recetas</div>
                        </a>
                    </li>
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page" >
                <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center" style="background-color: #4CAF50 !important; color: white;" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="px-0 nav-item nav-link me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm" style="color:#FFFFFF; background-color: #4CAF50 !important;" ></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

                        <!-- /Search -->
                        <ul class="flex-row navbar-nav align-items-center ms-auto">
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online" style="border: 2px solid #66BB6A !important;">
                                        <img src="{{ asset('assets/assets/img/avatars/1.png') }}" alt class="h-auto w-px-40 rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" style="background-color: #1B5E20 !important;">
                                    <li>
                                        <a class="dropdown-item" href="#" style="color: #FFFFFF !important;">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="{{ asset('assets/assets/img/avatars/1.png') }}" alt class="h-auto w-px-40 rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                                                    <small class="text-muted">Admin</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.profile.edit') }}" style="color: #FFFFFF !important; transition: background-color 0.3s ease;" onmouseover="this.style.backgroundColor='#FFA500'" onmouseout="this.style.backgroundColor='#1B5E20'">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">Perfil</span>
                                        </a>
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" style="color: #FFFFFF !important; transition: background-color 0.3s ease;" onmouseover="this.style.backgroundColor='#FFA500'" onmouseout="this.style.backgroundColor='#1B5E20'">
                                                <i class="bx bx-power-off me-2"></i>
                                                <span class="align-middle">Finalizar sesión</span>
                                            </a>
                                        </form>
                                    </li>
                                </ul>

                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <main class="py-12">
                    @yield('content')
                </main>
                <!-- / Navbar -->
            </div>
        </div>
        <!-- / Layout wrapper -->
    </div>

    <!-- Core JS -->
    <script src="{{ asset('assets/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/assets/vendor/js/menu.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/assets/js/main.js') }}"></script>

    <!-- Bootstrap Icons CDN -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>

</html>
