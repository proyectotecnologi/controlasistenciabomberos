@extends('layouts.admin')

@section('content')
<div class="content" style="margin-left: 20px">
    <div class="container-fluid">
        <!-- Encabezado -->
        <div class="row mb-3">
            <div class="col-12">
                <h1><i class="bi bi-person-plus-fill"></i> Creación de Nuevo Miembro</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/miembros') }}">Miembros</a></li>
                        <li class="breadcrumb-item active">Crear nuevo</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Mensajes de error -->
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5><i class="bi bi-exclamation-triangle-fill"></i> Por favor corrija los siguientes errores:</h5>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Formulario -->
        <form action="{{ url('/miembros') }}" method="POST" enctype="multipart/form-data" id="formMiembro">
            @csrf
            
            <div class="row">
                <!-- Columna principal -->
                <div class="col-md-9">
                    <!-- Card: Información Personal -->
                    <div class="card card-outline card-primary mb-3">
                        <div class="card-header">
                            <h3 class="card-title"><i class="bi bi-person-badge"></i> <b>Información Personal</b></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="grado"><i class="bi bi-award"></i> Grado <span class="text-danger">*</span></label>
                                        <input type="text" name="grado" id="grado" value="{{ old('grado') }}" 
                                            class="form-control @error('grado') is-invalid @enderror" 
                                            placeholder="Ej: Capitán" required>
                                        @error('grado')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cargo"><i class="bi bi-briefcase"></i> Cargo <span class="text-danger">*</span></label>
                                        <input type="text" name="cargo" id="cargo" value="{{ old('cargo') }}" 
                                            class="form-control @error('cargo') is-invalid @enderror" 
                                            placeholder="Ej: Jefe de Unidad" required>
                                        @error('cargo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nombre_apellido"><i class="bi bi-person"></i> Nombres y Apellidos <span class="text-danger">*</span></label>
                                        <input type="text" name="nombre_apellido" id="nombre_apellido" 
                                            value="{{ old('nombre_apellido') }}" 
                                            class="form-control @error('nombre_apellido') is-invalid @enderror" 
                                            placeholder="Nombres completos" required>
                                        @error('nombre_apellido')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="ci"><i class="bi bi-credit-card"></i> CI <span class="text-danger">*</span></label>
                                        <input type="text" name="ci" id="ci" value="{{ old('ci') }}" 
                                            class="form-control @error('ci') is-invalid @enderror" 
                                            placeholder="1234567" required>
                                        @error('ci')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="fecha_de_nacimiento"><i class="bi bi-calendar"></i> Fecha de Nacimiento <span class="text-danger">*</span></label>
                                        <input type="date" name="fecha_de_nacimiento" id="fecha_de_nacimiento" 
                                            value="{{ old('fecha_de_nacimiento') }}" 
                                            class="form-control @error('fecha_de_nacimiento') is-invalid @enderror" 
                                            max="{{ date('Y-m-d') }}" required>
                                        @error('fecha_de_nacimiento')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="genero"><i class="bi bi-gender-ambiguous"></i> Género <span class="text-danger">*</span></label>
                                        <select name="genero" id="genero" class="form-control @error('genero') is-invalid @enderror" required>
                                            <option value="">Seleccionar</option>
                                            <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                            <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                        </select>
                                        @error('genero')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="telefono"><i class="bi bi-telephone"></i> Teléfono <span class="text-danger">*</span></label>
                                        <input type="tel" name="telefono" id="telefono" value="{{ old('telefono') }}" 
                                            class="form-control @error('telefono') is-invalid @enderror" 
                                            placeholder="Ej: 71234567" required>
                                        @error('telefono')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email"><i class="bi bi-envelope"></i> Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email" value="{{ old('email') }}" 
                                            class="form-control @error('email') is-invalid @enderror" 
                                            placeholder="correo@ejemplo.com" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="direccion"><i class="bi bi-house"></i> Dirección <span class="text-danger">*</span></label>
                                        <input type="text" name="direccion" id="direccion" value="{{ old('direccion') }}" 
                                            class="form-control @error('direccion') is-invalid @enderror" 
                                            placeholder="Av. Principal #123" required>
                                        @error('direccion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="estado"><i class="bi bi-check-circle"></i> Estado</label>
                                        <select name="estado" id="estado" class="form-control">
                                            <option value="1" {{ old('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                                            <option value="0" {{ old('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                            {{-- <option value="Licencia" {{ old('estado') == 'Licencia' ? 'selected' : '' }}>Licencia</option> --}}
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="division_o_dependencia"><i class="bi bi-building"></i> División <span class="text-danger">*</span></label>
                                        <input type="text" name="division_o_dependencia" id="division_o_dependencia" 
                                            value="{{ old('division_o_dependencia') }}" 
                                            class="form-control @error('division_o_dependencia') is-invalid @enderror" 
                                            placeholder="Ej: División A" required>
                                        @error('division_o_dependencia')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna lateral: Fotografía -->
                <div class="col-md-3">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="bi bi-camera"></i> <b>Fotografía</b></h3>
                        </div>
                        <div class="card-body text-center">
                            <!-- Vista previa de la imagen -->
                            <div class="mb-3">
                                <img id="photo" src="{{ asset('assets/img/avatar-default.png') }}" 
                                    class="img-thumbnail" style="max-width: 100%; max-height: 300px;" 
                                    alt="Vista previa">
                            </div>

                            <!-- Opciones de carga -->
                            <div class="btn-group-vertical w-100 mb-2">
                                <label for="file" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-upload"></i> Subir desde archivo
                                </label>
                                <input type="file" id="file" name="fotografia" class="d-none" accept="image/*">
                                
                                <button type="button" class="btn btn-outline-success btn-sm" id="startCamera">
                                    <i class="bi bi-camera-video"></i> Activar cámara
                                </button>
                            </div>

                            <!-- Video de cámara -->
                            <div id="cameraContainer" style="display: none;">
                                <video id="video" width="100%" autoplay class="border rounded mb-2"></video>
                                <div class="btn-group w-100">
                                    <button type="button" class="btn btn-success btn-sm" id="snap">
                                        <i class="bi bi-camera"></i> Capturar
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" id="stopCamera">
                                        <i class="bi bi-x-circle"></i> Cerrar
                                    </button>
                                </div>
                            </div>

                            <canvas id="canvas" style="display: none;"></canvas>
                            <input type="hidden" name="fotografia_base64" id="fotografia_base64">
                            
                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-info-circle"></i> Formato: JPG, PNG (Máx: 2MB)
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ url('/miembros') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Guardar registro
                            </button>
                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise"></i> Limpiar formulario
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const photo = document.getElementById('photo');
    const snap = document.getElementById("snap");
    const inputBase64 = document.getElementById("fotografia_base64");
    const startCameraBtn = document.getElementById("startCamera");
    const stopCameraBtn = document.getElementById("stopCamera");
    const cameraContainer = document.getElementById("cameraContainer");
    const fileInput = document.getElementById('file');

    const WIDTH = 640;
    const HEIGHT = 640;
    let stream = null;

    // Activar cámara
    startCameraBtn.addEventListener("click", function() {
        navigator.mediaDevices.getUserMedia({ video: true, audio: false })
            .then(function(mediaStream) {
                stream = mediaStream;
                video.srcObject = stream;
                cameraContainer.style.display = "block";
                startCameraBtn.style.display = "none";
            })
            .catch(function(err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo acceder a la cámara: ' + err.message
                });
            });
    });

    // Cerrar cámara
    stopCameraBtn.addEventListener("click", function() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
        cameraContainer.style.display = "none";
        startCameraBtn.style.display = "block";
    });

    // Capturar foto
    snap.addEventListener("click", function() {
        const context = canvas.getContext('2d');
        canvas.width = WIDTH;
        canvas.height = HEIGHT;
        context.drawImage(video, 0, 0, WIDTH, HEIGHT);
        
        const dataURL = canvas.toDataURL('image/png');
        photo.src = dataURL;
        inputBase64.value = dataURL;
        
        // Cerrar cámara después de capturar
        stopCameraBtn.click();
        
        Swal.fire({
            icon: 'success',
            title: 'Foto capturada',
            text: 'La fotografía ha sido capturada correctamente',
            timer: 1500,
            showConfirmButton: false
        });
    });

    // Subir archivo
    fileInput.addEventListener('change', function(evt) {
        const file = evt.target.files[0];
        if (!file) return;
        
        // Validar tamaño (2MB máximo)
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'Archivo muy grande',
                text: 'La imagen no debe superar los 2MB'
            });
            fileInput.value = '';
            return;
        }
        
        // Validar tipo
        if (!file.type.match('image.*')) {
            Swal.fire({
                icon: 'error',
                title: 'Formato inválido',
                text: 'Solo se permiten imágenes (JPG, PNG)'
            });
            fileInput.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const imgData = e.target.result;
            photo.src = imgData;
            inputBase64.value = imgData;
        };
        reader.readAsDataURL(file);
    });

    // Validación del formulario
    document.getElementById('formMiembro').addEventListener('submit', function(e) {
        const requiredFields = this.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Campos incompletos',
                text: 'Por favor complete todos los campos obligatorios'
            });
        }
    });
});
</script>

<style>
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .is-invalid {
        border-color: #dc3545 !important;
    }
    
    .card-header {
        background-color: #f8f9fa;
    }
    
    .btn-group-vertical .btn {
        margin-bottom: 5px;
    }
    
    #photo {
        transition: all 0.3s ease;
    }
    
    #photo:hover {
        transform: scale(1.02);
    }
</style>
@endsection