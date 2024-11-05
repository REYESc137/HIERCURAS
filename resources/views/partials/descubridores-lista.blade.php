@foreach ($descubridores as $descubridor)
    <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center flex-column flex-md-row">
        <div class="d-flex flex-column flex-md-row align-items-center">
            <img src="{{ asset('/assets/img/descubridores/' . ($descubridor->foto ?: 'default.jpg')) }}" alt="Imagen de {{ $descubridor->nombre }}" class="mb-3 discoverer-img rounded-circle mb-md-0 me-md-3" style="width: 100px; height: 100px; object-fit: cover;">
            <div>
                <h5 class="mb-1" style="color: #2E7D32;">{{ $descubridor->nombre }}</h5>
                <p class="mb-1"><strong>País:</strong> {{ $descubridor->pais->nombre ?? 'N/A' }}</p>
                <p class="mb-1"><strong>Lugar de Nacimiento:</strong> {{ $descubridor->lugar_nacimiento }}</p>
            </div>
        </div>
        <div class="mt-2 d-flex mt-md-0">
            <button class="btn btn-outline-success btn-sm me-1" data-bs-toggle="modal" data-bs-target="#viewDiscovererModal-{{ $descubridor->id }}">
                <i class="fas fa-search"></i>
            </button>
            <button class="btn btn-outline-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editDiscovererModal-{{ $descubridor->id }}">
                <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteDiscovererModal-{{ $descubridor->id }}">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
    </div>
@endforeach
