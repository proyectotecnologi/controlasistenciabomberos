@extends('layouts.admin')

@section('content')
<div class="content" style="margin-left: 20px">
    <div class="container-fluid">
        <!-- Encabezado -->
        <div class="row mb-3">
            <div class="col-12">
                <h1><i class="bi bi-clock-history"></i> Sistema de Marcación de Asistencias</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Marcaciones</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if($message = Session::get('mensaje'))
            <script>
                Swal.fire({
                    title: "¡Registro exitoso!",
                    text: "{{ $message }}",
                    icon: "success",
                    timer: 3000
                });
            </script>
        @endif

        <div class="row">
            <!-- Columna de Marcación -->
            <div class="col-md-8">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="bi bi-fingerprint"></i> <b>Marcar Asistencia</b></h3>
                    </div>
                    <div class="card-body">
                        <!-- Reloj en tiempo real -->
                        <div class="text-center mb-4 p-4 bg-light rounded">
                            <h2 class="mb-0" id="reloj" style="font-size: 3rem; font-weight: bold; color: #007bff;">
                                --:--:--
                            </h2>
                            <p class="mb-0 mt-2" id="fecha" style="font-size: 1.2rem; color: #6c757d;">
                                --- -- de ------- de ----
                            </p>
                        </div>

                        <!-- Formulario de Marcación -->
                        <form id="formMarcacion">
                            @csrf
                            
                            <!-- CI del Miembro -->
                            <div class="form-group">
                                <label for="ci"><i class="bi bi-credit-card"></i> Carnet de Identidad <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-lg" id="ci" 
                                        name="ci" placeholder="Ingrese su CI" required autofocus>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" id="btnVerificar">
                                            <i class="bi bi-search"></i> Verificar
                                        </button>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Ingrese su número de carnet sin puntos ni guiones</small>
                            </div>

                            <!-- Información del Miembro (Oculto hasta verificar) -->
                            <div id="infoMiembro" style="display: none;">
                                <div class="alert alert-success" role="alert">
                                    <div class="row align-items-center">
                                        <div class="col-md-2 text-center">
                                            <img id="fotoMiembro" src="" class="img-thumbnail rounded-circle" 
                                                style="width: 80px; height: 80px; object-fit: cover;" alt="Foto">
                                        </div>
                                        <div class="col-md-10">
                                            <h5 class="mb-1"><i class="bi bi-person-check-fill"></i> Miembro Verificado</h5>
                                            <p class="mb-1"><strong>Nombre:</strong> <span id="nombreMiembro"></span></p>
                                            <p class="mb-1"><strong>Grado:</strong> <span id="gradoMiembro"></span></p>
                                            <p class="mb-0"><strong>División:</strong> <span id="divisionMiembro"></span></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Fecha y Hora de Marcación -->
                                {{-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha_marcacion"><i class="bi bi-calendar3"></i> Fecha</label>
                                            <input type="date" class="form-control" id="fecha_marcacion" 
                                                name="fecha_marcacion" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="hora_marcacion"><i class="bi bi-clock"></i> Hora</label>
                                            <input type="time" class="form-control" id="hora_marcacion" 
                                                name="hora_marcacion" readonly step="1">
                                        </div>
                                    </div>
                                </div> --}}

                                 <!-- Fecha y Hora de Marcación - EDITABLES -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fecha_marcacion"><i class="bi bi-calendar3"></i> Fecha <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="fecha_marcacion" 
                        name="fecha_marcacion" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="hora_marcacion"><i class="bi bi-clock"></i> Hora <span class="text-danger">*</span></label>
                    <input type="time" class="form-control" id="hora_marcacion" 
                        name="hora_marcacion" required step="1">
                </div>
            </div>
        </div>

        <!-- Botón para usar hora actual -->
        <div class="form-group text-center">
            <button type="button" class="btn btn-outline-primary btn-sm" id="btnHoraActual">
                <i class="bi bi-clock-fill"></i> Usar Hora Actual
            </button>
        </div>


                                <input type="hidden" id="miembro_id" name="miembro_id">

                                <!-- Botón de Marcar -->
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-success btn-lg" id="btnMarcar">
                                        <i class="bi bi-check-circle"></i> MARCAR ASISTENCIA
                                    </button>
                                </div>
                            </div>

                            <!-- Mensaje de error -->
                            <div id="errorMiembro" class="alert alert-danger mt-3" style="display: none;">
                                <i class="bi bi-exclamation-triangle-fill"></i> <span id="errorTexto"></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Columna de Últimas Marcaciones -->
            <div class="col-md-4">
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="bi bi-list-check"></i> <b>Últimas Marcaciones</b></h3>
                    </div>
                    <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                        <div id="ultimasMarcaciones">
                            <div class="text-center text-muted">
                                <i class="bi bi-hourglass-split" style="font-size: 3rem;"></i>
                                <p>Cargando marcaciones...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Asistencias del Día -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title"><i class="bi bi-table"></i> <b>Marcaciones de Hoy</b></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" id="btnRecargar">
                                <i class="bi bi-arrow-clockwise"></i> Recargar
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tablaMarcaciones" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Nro</th>
                                    <th>Foto</th>
                                    <th>CI</th>
                                    <th>Nombre</th>
                                    <th>Grado</th>
                                    <th>Hora Marcación</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody id="bodyMarcaciones">
                                <!-- Se llenará dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // ========== RELOJ EN TIEMPO REAL ==========
    function actualizarReloj() {
        const ahora = new Date();
        
        // Formato de hora: HH:MM:SS
        const horas = String(ahora.getHours()).padStart(2, '0');
        const minutos = String(ahora.getMinutes()).padStart(2, '0');
        const segundos = String(ahora.getSeconds()).padStart(2, '0');
        document.getElementById('reloj').textContent = `${horas}:${minutos}:${segundos}`;
        
        // Formato de fecha: Día DD de Mes de AAAA
        const dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                       'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        
        const diaSemana = dias[ahora.getDay()];
        const dia = ahora.getDate();
        const mes = meses[ahora.getMonth()];
        const anio = ahora.getFullYear();
        
        document.getElementById('fecha').textContent = `${diaSemana} ${dia} de ${mes} de ${anio}`;
        
        // Establecer valores por defecto (pero ahora editables)
        if (!document.getElementById('fecha_marcacion').value) {
            document.getElementById('fecha_marcacion').value = ahora.toISOString().split('T')[0];
        }
        if (!document.getElementById('hora_marcacion').value) {
            document.getElementById('hora_marcacion').value = `${horas}:${minutos}`;
        }
    }
    
    // Actualizar cada segundo
    actualizarReloj();
    setInterval(actualizarReloj, 1000);

    // ========== BOTÓN USAR HORA ACTUAL ==========
    document.getElementById('btnHoraActual').addEventListener('click', function() {
        const ahora = new Date();
        
        // Formatear fecha YYYY-MM-DD
        const fecha = ahora.toISOString().split('T')[0];
        
        // Formatear hora HH:MM:SS
        const horas = String(ahora.getHours()).padStart(2, '0');
        const minutos = String(ahora.getMinutes()).padStart(2, '0');
        const segundos = String(ahora.getSeconds()).padStart(2, '0');
        const hora = `${horas}:${minutos}:${segundos}`;
        
        document.getElementById('fecha_marcacion').value = fecha;
        document.getElementById('hora_marcacion').value = hora;
        
        Swal.fire({
            icon: 'success',
            title: 'Hora actual establecida',
            text: 'Se ha configurado la fecha y hora actual',
            timer: 2000,
            showConfirmButton: false
        });
    });

    // ========== VERIFICAR CI CON AXIOS ==========
    const btnVerificar = document.getElementById('btnVerificar');
    const ciInput = document.getElementById('ci');
    const infoMiembro = document.getElementById('infoMiembro');
    const errorMiembro = document.getElementById('errorMiembro');

    // También verificar al presionar Enter
    ciInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            btnVerificar.click();
        }
    });

    btnVerificar.addEventListener('click', function() {
        const ci = ciInput.value.trim();
        
        if (ci === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Campo vacío',
                text: 'Por favor ingrese su número de CI'
            });
            return;
        }

        // Deshabilitar botón mientras verifica
        btnVerificar.disabled = true;
        btnVerificar.innerHTML = '<i class="bi bi-hourglass-split"></i> Verificando...';

        axios.post('{{ route("marcaciones.verificar") }}', {
            ci: ci
        })
        .then(function(response) {
            if (response.data.success) {
                const miembro = response.data.miembro;
                
                // Mostrar información del miembro
                document.getElementById('miembro_id').value = miembro.id;
                document.getElementById('nombreMiembro').textContent = miembro.nombre_apellido;
                document.getElementById('gradoMiembro').textContent = miembro.grado;
                document.getElementById('divisionMiembro').textContent = miembro.division_o_dependencia;
                
                // Cargar foto
                if (miembro.fotografia) {
                    document.getElementById('fotoMiembro').src = '{{ asset("storage") }}/' + miembro.fotografia;
                } else {
                    document.getElementById('fotoMiembro').src = '{{ asset("assets/img/avatar-default.png") }}';
                }
                
                infoMiembro.style.display = 'block';
                errorMiembro.style.display = 'none';
                
                // Establecer fecha y hora actual si no están definidas
                if (!document.getElementById('fecha_marcacion').value) {
                    const ahora = new Date();
                    document.getElementById('fecha_marcacion').value = ahora.toISOString().split('T')[0];
                    document.getElementById('hora_marcacion').value = ahora.toTimeString().split(' ')[0].substring(0, 8);
                }
                
                Swal.fire({
                    icon: 'success',
                    title: '¡Verificado!',
                    text: 'Miembro encontrado correctamente',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        })
        .catch(function(error) {
            infoMiembro.style.display = 'none';
            errorMiembro.style.display = 'block';
            
            if (error.response && error.response.data.message) {
                document.getElementById('errorTexto').textContent = error.response.data.message;
            } else {
                document.getElementById('errorTexto').textContent = 'CI no encontrado en el sistema';
            }
        })
        .finally(function() {
            btnVerificar.disabled = false;
            btnVerificar.innerHTML = '<i class="bi bi-search"></i> Verificar';
        });
    });

    // ========== MARCAR ASISTENCIA ==========
    const formMarcacion = document.getElementById('formMarcacion');
    
    formMarcacion.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const ci = document.getElementById('ci').value;
        const fecha = document.getElementById('fecha_marcacion').value;
        const hora = document.getElementById('hora_marcacion').value;
        
        // Validar campos
        if (!fecha || !hora) {
            Swal.fire({
                icon: 'error',
                title: 'Campos incompletos',
                text: 'Por favor complete la fecha y hora de marcación'
            });
            return;
        }

        // Combinar fecha y hora
        const fechaHora = `${fecha} ${hora}`;
        
        // Validar que la fecha/hora no sea futura (opcional)
        const fechaMarcacion = new Date(fechaHora);
        const ahora = new Date();
        if (fechaMarcacion > ahora) {
            Swal.fire({
                icon: 'warning',
                title: 'Fecha futura',
                text: 'La fecha y hora de marcación no puede ser futura',
                showCancelButton: true,
                confirmButtonText: 'Continuar igual',
                cancelButtonText: 'Corregir'
            }).then((result) => {
                if (result.isConfirmed) {
                    enviarMarcacion(ci, fechaHora);
                }
            });
        } else {
            enviarMarcacion(ci, fechaHora);
        }
    });

    // Función para enviar marcación
    function enviarMarcacion(ci, fechaHora) {
        Swal.fire({
            title: '¿Confirmar marcación?',
            html: `<p>Se registrará la asistencia para:</p>
                  <p><strong>CI:</strong> ${ci}</p>
                  <p><strong>Fecha:</strong> ${fechaHora.split(' ')[0]}</p>
                  <p><strong>Hora:</strong> ${fechaHora.split(' ')[1]}</p>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, registrar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post('{{ route("marcaciones.store") }}', {
                    ci: ci,
                    fecha_marcacion: fechaHora
                })
                .then(function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Marcación registrada!',
                        text: response.data.message,
                        timer: 3000
                    });
                    
                    // Limpiar formulario
                    formMarcacion.reset();
                    infoMiembro.style.display = 'none';
                    ciInput.focus();
                    
                    // Recargar listas
                    cargarUltimasMarcaciones();
                    cargarMarcacionesHoy();
                })
                .catch(function(error) {
                    let mensaje = 'Error al registrar la marcación';
                    if (error.response && error.response.data.message) {
                        mensaje = error.response.data.message;
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: mensaje
                    });
                });
            }
        });
    }

    // Resto del código (cargarUltimasMarcaciones, cargarMarcacionesHoy, etc.) se mantiene igual...
    // ========== CARGAR ÚLTIMAS MARCACIONES ==========
    function cargarUltimasMarcaciones() {
        axios.get('{{ route("marcaciones.ultimas") }}')
            .then(function(response) {
                const marcaciones = response.data;
                let html = '';
                
                if (marcaciones.length === 0) {
                    html = '<div class="text-center text-muted"><p>No hay marcaciones recientes</p></div>';
                } else {
                    marcaciones.forEach(function(item) {
                        html += `
                            <div class="border-bottom pb-2 mb-2">
                                <div class="d-flex align-items-center">
                                    <img src="${item.foto || '{{ asset("assets/img/avatar-default.png") }}'}" 
                                        class="rounded-circle mr-2" style="width: 40px; height: 40px; object-fit: cover;">
                                    <div>
                                        <strong>${item.nombre}</strong>
                                        <br><small class="text-muted">${item.fecha} ${item.hora}</small>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                }
                
                document.getElementById('ultimasMarcaciones').innerHTML = html;
            })
            .catch(function(error) {
                console.error('Error al cargar últimas marcaciones:', error);
            });
    }

    // ========== CARGAR MARCACIONES DE HOY ==========
    function cargarMarcacionesHoy() {
        axios.get('{{ route("marcaciones.hoy") }}')
            .then(function(response) {
                const marcaciones = response.data;
                let html = '';
                
                if (marcaciones.length === 0) {
                    html = '<tr><td colspan="7" class="text-center text-muted">No hay marcaciones hoy</td></tr>';
                } else {
                    marcaciones.forEach(function(item, index) {
                        html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td><img src="${item.foto || '{{ asset("assets/img/avatar-default.png") }}'}" 
                                    class="img-thumbnail" style="width: 40px; height: 40px; object-fit: cover;"></td>
                                <td>${item.ci}</td>
                                <td>${item.nombre}</td>
                                <td>${item.grado}</td>
                                <td>${item.hora}</td>
                                <td><span class="badge badge-success">Registrado</span></td>
                            </tr>
                        `;
                    });
                }
                
                document.getElementById('bodyMarcaciones').innerHTML = html;
            })
            .catch(function(error) {
                console.error('Error al cargar marcaciones de hoy:', error);
            });
    }

    // Botón recargar
    document.getElementById('btnRecargar').addEventListener('click', function() {
        cargarMarcacionesHoy();
        cargarUltimasMarcaciones();
        
        Swal.fire({
            icon: 'success',
            title: 'Actualizado',
            text: 'Datos recargados correctamente',
            timer: 1500,
            showConfirmButton: false
        });
    });

    // Cargar al iniciar
    cargarUltimasMarcaciones();
    cargarMarcacionesHoy();
    
    // Recargar automáticamente cada 30 segundos
    setInterval(function() {
        cargarUltimasMarcaciones();
        cargarMarcacionesHoy();
    }, 30000);
});
</script>

<style>
    #reloj {
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }

    .form-control-lg {
        font-size: 1.5rem;
    }

    .card-body {
        padding: 1.5rem;
    }
</style>
@endsection