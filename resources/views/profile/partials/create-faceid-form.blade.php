<section class="space-y-6 p-6 bg-[#F5F5DC] rounded-lg shadow-lg">
    <header class="bg-[#98FB98] p-4 rounded-lg shadow-sm">
        <h2 class="text-xl font-semibold text-white">
            {{ __('Configurar Face ID') }}
        </h2>
        <p class="mt-1 text-sm text-[#556B2F]">
            {{ __('Asegúrese de configurar su Face ID para mejorar la seguridad de su cuenta.') }}
        </p>
    </header>

    <form method="POST" action="{{ route('faceid.register') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('post')

        <div>
            <!-- Botón para abrir la cámara -->
            <button type="button" onclick="openCamera()" class="font-bold py-2 px-4 rounded-full shadow-lg" style="color: white !important; background-color: #6B8E23 !important;">
                {{ __('Agregar datos faciales') }}
            </button>
            <!-- Botón para cerrar la cámara -->
            <button type="button" onclick="closeCamera()" id="close-camera" class="font-bold py-2 px-4 rounded-full shadow-lg" style="color: white !important; background-color: #B22222 !important; display: none;">
                {{ __('Cerrar Cámara') }}
            </button>
            <!-- Botón para capturar la foto -->
            <button type="button" onclick="captureImageAndKeep()" id="take-photo" class="font-bold py-2 px-4 rounded-full shadow-lg" style="color: white !important; background-color: #4682B4 !important; display: none;">
                {{ __('Tomar Foto') }}
            </button>
            <!-- Elementos de video y canvas para captura -->
            <video id="camera" width="320" height="240" autoplay hidden></video>
            <canvas id="snapshot" width="320" height="240" hidden></canvas>
            <input type="hidden" id="faceid_base64" name="image" />

            <!-- Vista previa de la foto capturada -->
            <div id="photo-preview" style="display: none;">
                <h3 class="mt-4 text-lg text-[#6B4226]">{{ __('Foto Capturada:') }}</h3>
                <img id="captured-image" src="" alt="Foto capturada" width="320" height="240" class="border border-[#6B8E23] rounded-md mt-2" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <!-- Botón de guardar -->
            <x-primary-button class="font-bold py-2 px-4 rounded-full shadow-lg" style="color: white !important; background-color: #6B8E23 !important;">
                {{ __('Guardar') }}
            </x-primary-button>
        </div>
    </form>
</section>

<script>
    let cameraStream;

    // Función para abrir la cámara
    function openCamera() {
        const video = document.getElementById('camera');
        const closeButton = document.getElementById('close-camera');
        const takePhotoButton = document.getElementById('take-photo');

        // Acceder a la cámara
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                cameraStream = stream;
                video.srcObject = stream;
                video.hidden = false;
                closeButton.style.display = 'inline-block'; // Mostrar el botón de cerrar
                takePhotoButton.style.display = 'inline-block'; // Mostrar el botón de tomar foto
            })
            .catch(err => console.error("Error al acceder a la cámara:", err));
    }

    // Función para capturar la foto y mostrarla
    function captureImageAndKeep() {
        const video = document.getElementById('camera');
        const canvas = document.getElementById('snapshot');
        const base64Input = document.getElementById('faceid_base64');
        const context = canvas.getContext('2d');
        const takePhotoButton = document.getElementById('take-photo');
        const closeButton = document.getElementById('close-camera');
        const photoPreview = document.getElementById('photo-preview');
        const capturedImage = document.getElementById('captured-image');

        // Ajustar el tamaño del canvas a las dimensiones del video
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        // Dibujar el contenido del video en el canvas
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Convertir la imagen a base64 y almacenarla
        const imageData = canvas.toDataURL('image/png');
        base64Input.value = imageData.split(',')[1]; // Solo la parte Base64

        // Mostrar la imagen capturada en el formulario
        capturedImage.src = imageData;
        photoPreview.style.display = 'block';

        // Ocultar la cámara y botones
        video.hidden = true;
        closeButton.style.display = 'none';
        takePhotoButton.style.display = 'none';
    }

    // Función para cerrar la cámara
    function closeCamera() {
        const video = document.getElementById('camera');
        const closeButton = document.getElementById('close-camera');
        const takePhotoButton = document.getElementById('take-photo');

        if (cameraStream) {
            cameraStream.getTracks().forEach(track => track.stop()); // Detener el stream de la cámara
        }
        video.hidden = true;
        closeButton.style.display = 'none';
        takePhotoButton.style.display = 'none';
    }
</script>
