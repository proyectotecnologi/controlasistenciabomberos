@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Listado de permisos</h1>



        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><b>Usuarios con permisos registrados</b></h3>
                        <div class="card-tools">
                            <!-- Botón para abrir el modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#crearPermisoModal">
                                <i class="bi bi-plus-square-fill"></i> Agregar nuevo permiso
                            </button>
                        </div>
                    </div>

                    <div class="card-body" style="display: block;">
                        <table id="example1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Nro</th>
                                    <th>Nombre del usuario</th>
                                    <th>Fecha desde</th>
                                    <th>Fecha hasta</th>
                                    <th>Motivo</th>
                                    <th>Descripción</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $contador = 0; @endphp
                                @foreach ($permisos as $permiso)
                                    <tr>
                                        <td>{{ ++$contador }}</td>
                                        <td>{{ $permiso->miembro->nombre_apellido ?? 'sin nombre' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($permiso->desde)->translatedFormat('l, d F Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($permiso->hasta)->translatedFormat('l, d F Y') }}</td>

                                        <td>{{ $permiso->motivo }}</td>
                                        <td>{{ $permiso->descripcion }}</td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <!-- Botón Editar -->
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#editPermisoModal-{{ $permiso->id }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>

                                                <!-- Botón Eliminar -->
                                                <form action="{{ route('eliminar_permiso', $permiso->id) }}" method="POST"
                                                    style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('¿Seguro que desea eliminar este permiso?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>

                                    </tr>

                                    <!-- Modal Editar -->
                                    <div class="modal fade" id="editPermisoModal-{{ $permiso->id }}" tabindex="-1"
                                        aria-labelledby="editPermisoModalLabel-{{ $permiso->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('actualizar_permiso', $permiso->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="editPermisoModalLabel-{{ $permiso->id }}">Editar Permiso
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Cerrar">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="miembro_id_{{ $permiso->id }}">Funcionario</label>
                                                            <select name="miembro_id" id="miembro_id_{{ $permiso->id }}"
                                                                class="form-control" required>
                                                                @foreach ($miembros as $miembro)
                                                                    <option value="{{ $miembro->id }}"
                                                                        {{ $permiso->miembro_id == $miembro->id ? 'selected' : '' }}>
                                                                        {{ $miembro->nombre_apellido }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="desde_{{ $permiso->id }}">Fecha desde</label>
                                                            <input type="date" name="desde"
                                                                id="desde_{{ $permiso->id }}" class="form-control"
                                                                value="{{ $permiso->desde }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="hasta_{{ $permiso->id }}">Fecha hasta</label>
                                                            <input type="date" name="hasta"
                                                                id="hasta_{{ $permiso->id }}" class="form-control"
                                                                value="{{ $permiso->hasta }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="motivo_{{ $permiso->id }}">Motivo</label>
                                                            <select name="motivo" id="motivo_{{ $permiso->id }}"
                                                                class="form-control" required>
                                                                @foreach (['permiso', 'comision', 'salud', 'enfermedad', 'familiar', 'duelo', 'estudio', 'capacitacion', 'vacacion', 'tramite', 'judicial', 'otros'] as $motivo)
                                                                    <option value="{{ $motivo }}"
                                                                        {{ $permiso->motivo == $motivo ? 'selected' : '' }}>
                                                                        {{ ucfirst($motivo) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label
                                                                for="descripcion_{{ $permiso->id }}">Descripción</label>
                                                            <textarea name="descripcion" id="descripcion_{{ $permiso->id }}" class="form-control" rows="3">{{ $permiso->descripcion }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary">Actualizar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Crear Permiso -->
    <div class="modal fade" id="crearPermisoModal" tabindex="-1" aria-labelledby="crearPermisoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('crear_permiso') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="crearPermisoModalLabel">Agregar nuevo permiso</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Selección de Miembro -->
                        <div class="form-group">
                            <label for="miembro_id">Funcionario</label>
                            <select name="miembro_id" id="miembro_id" class="form-control" required>
                                <option value="">Seleccione un funcionario</option>
                                @foreach ($miembros as $miembro)
                                    <option value="{{ $miembro->id }}">{{ $miembro->nombre_apellido }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Fechas -->
                        <div class="form-group">
                            <label for="desde">Fecha desde</label>
                            <input type="date" name="desde" id="desde" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="hasta">Fecha hasta</label>
                            <input type="date" name="hasta" id="hasta" class="form-control" required>
                        </div>

                        <!-- Motivo -->
                        <div class="form-group">
                            <label for="motivo">Motivo</label>
                            <select name="motivo" id="motivo" class="form-control" required>
                                <option value="">Seleccione un motivo</option>
                                <option value="permiso">Permiso</option>
                                <option value="comision">Comisión</option>
                                <option value="salud">Salud</option>
                                <option value="enfermedad">Enfermedad</option>
                                <option value="familiar">Familiar</option>
                                <option value="duelo">Duelo</option>
                                <option value="estudio">Estudio</option>
                                <option value="capacitacion">Capacitación</option>
                                <option value="vacacion">Vacacion</option>
                                <option value="tramite">Trámite</option>
                                <option value="judicial">judicial</option>
                                <option value="otros">Otros</option>
                            </select>
                        </div>

                        <!-- Descripción -->
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" rows="3" placeholder="Opcional"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar permiso</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6'
            });
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33'
            });
        @endif
    </script>
@endsection
