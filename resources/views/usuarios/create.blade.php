@extends('layouts.admin')

@section('content')
<div class="content" style="margin-left: 20px">
    <div class="container-fluid">
        <!-- Encabezado -->
        <div class="row mb-3">
            <div class="col-12">
                <h1><i class="bi bi-person-plus-fill"></i> Creación de Nuevo Usuario</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/usuarios') }}">Usuarios</a></li>
                        <li class="breadcrumb-item active">Crear nuevo</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Mensaje de éxito -->
        @if($message = Session::get('mensaje'))
            <script>
                Swal.fire({
                    title: "¡Registro exitoso!",
                    text: "{{ $message }}",
                    icon: "success",
                    timer: 3000,
                    showConfirmButton: false
                });
            </script>
        @endif

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
        <form method="POST" action="{{ url('usuarios') }}" enctype="multipart/form-data" id="formUsuario">
            @csrf
            
            <div class="row">
                <!-- Columna principal: Datos del usuario -->
                <div class="col-md-9">
                    <div class="card card-outline card-primary mb-3">
                        <div class="card-header">
                            <h3 class="card-title"><i class="bi bi-person-badge"></i> <b>Información del Usuario</b></h3>
                        </div>
                        <div class="card-body">
                            <!-- Nombre completo -->
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label">
                                    <i class="bi bi-person"></i> Nombres y Apellidos <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-8">
                                    <input id="name" type="text" 
                                        class="form-control @error('name') is-invalid @enderror" 
                                        name="name" value="{{ old('name') }}" 
                                        placeholder="Ingrese nombres y apellidos completos" 
                                        required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Nombre completo del usuario del sistema
                                    </small>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label">
                                    <i class="bi bi-envelope"></i> Correo Electrónico <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-8">
                                    <input id="email" type="email" 
                                        class="form-control @error('email') is-invalid @enderror" 
                                        name="email" value="{{ old('email') }}" 
                                        placeholder="usuario@ejemplo.com" 
                                        required autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Este correo será utilizado para iniciar sesión
                                    </small>
                                </div>
                            </div>

                            <!-- Contraseña -->
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label">
                                    <i class="bi bi-lock"></i> Contraseña <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input id="password" type="password" 
                                            class="form-control @error('password') is-invalid @enderror" 
                                            name="password" 
                                            placeholder="Mínimo 8 caracteres" 
                                            required autocomplete="new-password">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                <i class="bi bi-eye" id="eyeIcon"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <small class="form-text text-muted">
                                        Mínimo 8 caracteres. Se recomienda incluir letras, números y símbolos
                                    </small>
                                    <!-- Medidor de fortaleza -->
                                    <div class="progress mt-2" style="height: 5px;">
                                        <div id="passwordStrength" class="progress-bar" role="progressbar" 
                                            style="width: 0%"></div>
                                    </div>
                                    <small id="strengthText" class="form-text"></small>
                                </div>
                            </div>

                            <!-- Confirmar contraseña -->
                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label">
                                    <i class="bi bi-shield-check"></i> Confirmar Contraseña <span class="text-danger">*</span>
                                </label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input id="password-confirm" type="password" 
                                            class="form-control" 
                                            name="password_confirmation" 
                                            placeholder="Repita la contraseña" 
                                            required autocomplete="new-password">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                                <i class="bi bi-eye" id="eyeIconConfirm"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <small id="passwordMatch" class="form-text"></small>
                                </div>
                            </div>

                            <!-- Rol del usuario -->
                            <div class="form-group row">
                                <label for="roles" class="col-md-4 col-form-label">
                                    <i class="bi bi-award"></i> Rol del Usuario
                                </label>
                                <div class="col-md-8">
                                    <select name="roles[]" id="roles" class="form-control" multiple>
                                        @if(isset($roles))
                                            @foreach($roles as $rol)
                                                <option value="{{ $rol->name }}">{{ $rol->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="form-text text-muted">
                                        Puede seleccionar uno o más roles. Mantenga presionado Ctrl (Windows) o Cmd (Mac) para seleccionar múltiples
                                    </small>
                                </div>
                            </div>

                            <!-- Fecha de ingreso -->
                            <div class="form-group row">
                                <label for="fecha_ingreso" class="col-md-4 col-form-label">
                                    <i class="bi bi-calendar"></i> Fecha de Ingreso
                                </label>
                                <div class="col-md-8">
                                    <input type="date" name="fecha_ingreso" id="fecha_ingreso" 
                                        class="form-control" 
                                        value="{{ old('fecha_ingreso', date('Y-m-d')) }}"
                                        max="{{ date('Y-m-d') }}">
                                    <small class="form-text text-muted">
                                        Fecha de ingreso al sistema
                                    </small>
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
                            <!-- Vista previa -->
                            <div class="mb-3">
                                <img id="preview" 
                                    src="{{ asset('assets/img/avatar-default.png') }}" 
                                    class="img-thumbnail rounded-circle" 
                                    style="width: 200px; height: 200px; object-fit: cover;" 
                                    alt="Vista previa">
                            </div>

                            <!-- Input de archivo -->
                            <div class="custom-file mb-3">
                                <input type="file" class="custom-file-input" id="file" 
                                    name="fotografia" accept="image/*" lang="es">
                                <label class="custom-file-label" for="file">
                                    Seleccionar foto...
                                </label>
                            </div>

                            <!-- Botones adicionales -->
                            <div class="btn-group-vertical w-100">
                                <button type="button" class="btn btn-outline-primary btn-sm" id="openCamera">
                                    <i class="bi bi-camera-video"></i> Usar cámara web
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" id="removePhoto">
                                    <i class="bi bi-trash"></i> Quitar foto
                                </button>
                            </div>

                            <small class="text-muted d-block mt-3">
                                <i class="bi bi-info-circle"></i> Formatos permitidos: JPG, PNG<br>
                                Tamaño máximo: 2MB
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
                            <a href="{{ url('/usuarios') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary" id="btnSubmit">
                                <i class="bi bi-save"></i> Registrar Usuario
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

<!-- Modal Cámara Web -->
<div class="modal fade" id="cameraModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-camera-video"></i> Capturar Foto</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <video id="video" width="100%" autoplay></video>
                <canvas id="canvas" style="display: none;"></canvas>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="bi bi-x"></i> Cerrar
                </button>
                <button type="button" class="btn btn-success" id="capturePhoto">
                    <i class="bi bi-camera"></i> Capturar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // ========== PREVIEW DE IMAGEN ==========
    const fileInput = document.getElementById('file');
    const preview = document.getElementById('preview');
    const removePhotoBtn = document.getElementById('removePhoto');
    const defaultImage = "{{ asset('assets/img/avatar-default.png') }}";

    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        // Validar tamaño
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
                text: 'Solo se permiten imágenes (JPG, PNG, GIF)'
            });
            fileInput.value = '';
            return;
        }

        // Mostrar preview
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);

        // Actualizar label
        const fileName = file.name;
        document.querySelector('.custom-file-label').textContent = fileName;
    });

    // Quitar foto
    removePhotoBtn.addEventListener('click', function() {
        preview.src = defaultImage;
        fileInput.value = '';
        document.querySelector('.custom-file-label').textContent = 'Seleccionar foto...';
    });

    // ========== MOSTRAR/OCULTAR CONTRASEÑA ==========
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function() {
        const type = password.type === 'password' ? 'text' : 'password';
        password.type = type;
        eyeIcon.classList.toggle('bi-eye');
        eyeIcon.classList.toggle('bi-eye-slash');
    });

    const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
    const passwordConfirm = document.getElementById('password-confirm');
    const eyeIconConfirm = document.getElementById('eyeIconConfirm');

    togglePasswordConfirm.addEventListener('click', function() {
        const type = passwordConfirm.type === 'password' ? 'text' : 'password';
        passwordConfirm.type = type;
        eyeIconConfirm.classList.toggle('bi-eye');
        eyeIconConfirm.classList.toggle('bi-eye-slash');
    });

    // ========== MEDIDOR DE FORTALEZA DE CONTRASEÑA ==========
    const passwordStrength = document.getElementById('passwordStrength');
    const strengthText = document.getElementById('strengthText');

    password.addEventListener('input', function() {
        const value = this.value;
        let strength = 0;
        
        if (value.length >= 8) strength += 25;
        if (value.match(/[a-z]/)) strength += 25;
        if (value.match(/[A-Z]/)) strength += 25;
        if (value.match(/[0-9]/)) strength += 15;
        if (value.match(/[^a-zA-Z0-9]/)) strength += 10;

        passwordStrength.style.width = strength + '%';
        
        if (strength < 40) {
            passwordStrength.className = 'progress-bar bg-danger';
            strengthText.textContent = 'Contraseña débil';
            strengthText.className = 'form-text text-danger';
        } else if (strength < 70) {
            passwordStrength.className = 'progress-bar bg-warning';
            strengthText.textContent = 'Contraseña media';
            strengthText.className = 'form-text text-warning';
        } else {
            passwordStrength.className = 'progress-bar bg-success';
            strengthText.textContent = 'Contraseña fuerte';
            strengthText.className = 'form-text text-success';
        }
    });

    // ========== VERIFICAR COINCIDENCIA DE CONTRASEÑAS ==========
    const passwordMatch = document.getElementById('passwordMatch');

    passwordConfirm.addEventListener('input', function() {
        if (this.value === password.value && this.value !== '') {
            passwordMatch.textContent = '✓ Las contraseñas coinciden';
            passwordMatch.className = 'form-text text-success';
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        } else if (this.value !== '') {
            passwordMatch.textContent = '✗ Las contraseñas no coinciden';
            passwordMatch.className = 'form-text text-danger';
            this.classList.remove('is-valid');
            this.classList.add('is-invalid');
        } else {
            passwordMatch.textContent = '';
            this.classList.remove('is-valid', 'is-invalid');
        }
    });

    // ========== CÁMARA WEB ==========
    const openCameraBtn = document.getElementById('openCamera');
    const cameraModal = new bootstrap.Modal(document.getElementById('cameraModal'));
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const captureBtn = document.getElementById('capturePhoto');
    let stream = null;

    openCameraBtn.addEventListener('click', function() {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function(mediaStream) {
                stream = mediaStream;
                video.srcObject = stream;
                $('#cameraModal').modal('show');
            })
            .catch(function(err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo acceder a la cámara: ' + err.message
                });
            });
    });

    $('#cameraModal').on('hidden.bs.modal', function () {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
    });

    captureBtn.addEventListener('click', function() {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0);
        
        preview.src = canvas.toDataURL('image/png');
        $('#cameraModal').modal('hide');
        
        Swal.fire({
            icon: 'success',
            title: 'Foto capturada',
            text: 'La fotografía se guardará al registrar el usuario',
            timer: 2000,
            showConfirmButton: false
        });
    });

    // ========== VALIDACIÓN DEL FORMULARIO ==========
    document.getElementById('formUsuario').addEventListener('submit', function(e) {
        const pass = password.value;
        const passConfirm = passwordConfirm.value;

        if (pass !== passConfirm) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Las contraseñas no coinciden'
            });
            return false;
        }

        if (pass.length < 8) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'La contraseña debe tener al menos 8 caracteres'
            });
            return false;
        }
    });
});
</script>

<style>
    .form-group {
        margin-bottom: 1.5rem;
    }

    .custom-file-label::after {
        content: "Buscar";
    }

    .img-thumbnail {
        border: 3px solid #007bff;
        transition: all 0.3s ease;
    }

    .img-thumbnail:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }

    .input-group-append .btn {
        border-left: 0;
    }

    .btn-group-vertical .btn {
        margin-bottom: 8px;
    }

    #video {
        border-radius: 8px;
        border: 2px solid #007bff;
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 2px solid #007bff;
    }

    .is-valid {
        border-color: #28a745 !important;
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }
</style>
@endsection