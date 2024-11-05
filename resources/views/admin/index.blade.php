@extends('admin.layouts.menu-layouts')

@section('content')
    <div class="container-fluid py-5">
        <div class="tab-content">
            <div id="tab-1" class="tab-pane fade show p-0 active cen alin">
                <div class="row g-4">
                    <div class="col-lg-12">
                        <div class="row g-4">
                            <!-- Tarjeta de Usuarios -->
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="rounded position-relative fruite-item">
                                    <div class="fruite-img">
                                        <img src="{{ asset('assets/img/usuario.jpg') }}" class="img-fluid w-100 rounded-top card-img" alt="Usuarios">
                                    </div>
                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                        <h4>Usuarios</h4>
                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                            <a href="{{ route('admin.usuarios') }}" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                <i class="bi bi-arrow-right-circle-fill"></i> Ir
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tarjeta de Plantas -->
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="rounded position-relative fruite-item">
                                    <div class="fruite-img">
                                        <img src="{{ asset('assets/img/planta.jpg') }}" class="img-fluid w-100 rounded-top card-img" alt="Plantas">
                                    </div>
                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                        <h4>Plantas</h4>
                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                            <a href="{{ route('admin.plantas') }}" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                <i class="bi bi-arrow-right-circle-fill"></i> Ir
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tarjeta de Descubridores -->
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="rounded position-relative fruite-item">
                                    <div class="fruite-img">
                                        <img src="{{ asset('assets/img/des.jpg') }}" class="img-fluid w-100 rounded-top card-img" alt="Descubridores">
                                    </div>
                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                        <h4>Descubridores</h4>
                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                            <a href="{{ route('admin.descubridores') }}" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                <i class="bi bi-arrow-right-circle-fill"></i> Ir
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tarjeta de Recetas -->
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="rounded position-relative fruite-item">
                                    <div class="fruite-img">
                                        <img src="{{ asset('assets/img/receta.jpg') }}" class="img-fluid w-100 rounded-top card-img" alt="Recetas">
                                    </div>
                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                        <h4>Recetas</h4>
                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                            <a href="{{ route('admin.recetas') }}" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                <i class="bi bi-arrow-right-circle-fill"></i> Ir
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Puedes añadir más tarjetas aquí -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
