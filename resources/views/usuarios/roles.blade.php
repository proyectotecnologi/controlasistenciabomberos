@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Listado de Roles</h1>

        @if ($message = Session::get('mensaje'))
            <script>
                Swal.fire({
                    title: "Registro exitoso",
                    text: "{{ $message }}",
                    icon: "success"
                });
            </script>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><b>Lista de roles disponibles</b></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createRoleModal">
                                <i class="bi bi-plus-square-fill"></i> Agregar nuevo rol
                            </button>
                        </div>
                    </div>

                    <div class="card-body" style="display: block;">
                        <table id="example1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Nro</th>
                                    <th>Nombre Rol</th>
                                    <th>Permisos</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $contador = 0; ?>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td><?php echo $contador = $contador + 1; ?></td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @if ($role->permissions->isNotEmpty())
                                                @foreach ($role->permissions as $permission)
                                                    <span class="badge bg-primary">{{ $permission->name }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">Sin permiso</span>
                                            @endif
                                        </td>
                                        <td style="text-align: center;">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                    data-target="#editRoleModal-{{ $role->id }}">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#deleteRoleModal-{{ $role->id }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal Editar Rol -->
                                    <div class="modal fade" id="editRoleModal-{{ $role->id }}" tabindex="-1"
                                        aria-labelledby="editRoleModalLabel-{{ $role->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-success">
                                                    <h5 class="modal-title text-white"
                                                        id="editRoleModalLabel-{{ $role->id }}">
                                                        Editar Rol: {{ $role->name }}
                                                    </h5>
                                                    <button type="button" class="close text-white" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('roles.update', $role->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="name-{{ $role->id }}">Nombre del Rol <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="form-control"
                                                                id="name-{{ $role->id }}" name="name"
                                                                value="{{ $role->name }}" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Permisos disponibles</label>
                                                            <div class="border rounded p-3"
                                                                style="max-height: 300px; overflow-y: auto;">
                                                                @foreach ($permisos as $permission)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            id="permission-edit-{{ $role->id }}-{{ $permission->id }}"
                                                                            name="permissions[]"
                                                                            value="{{ $permission->name }}"
                                                                            @if ($role->hasPermissionTo($permission->name)) checked @endif>
                                                                        <label class="form-check-label"
                                                                            for="permission-edit-{{ $role->id }}-{{ $permission->id }}">
                                                                            {{ $permission->name }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">
                                                            Cancelar
                                                        </button>
                                                        <button type="submit" class="btn btn-success">
                                                            <i class="bi bi-save"></i> Actualizar Rol
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Eliminar Rol -->
                                    <div class="modal fade" id="deleteRoleModal-{{ $role->id }}" tabindex="-1"
                                        aria-labelledby="deleteRoleModalLabel-{{ $role->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                    <h5 class="modal-title text-white"
                                                        id="deleteRoleModalLabel-{{ $role->id }}">
                                                        Confirmar Eliminación
                                                    </h5>
                                                    <button type="button" class="close text-white" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-body">
                                                        <div class="text-center">
                                                            <i class="bi bi-exclamation-triangle text-danger"
                                                                style="font-size: 4rem;"></i>
                                                            <h4 class="mt-3">¿Estás seguro?</h4>
                                                            <p class="text-muted">
                                                                Estás a punto de eliminar el rol:
                                                                <strong>{{ $role->name }}</strong>
                                                            </p>
                                                            <p class="text-danger">
                                                                <small>Esta acción no se puede deshacer.</small>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">
                                                            Cancelar
                                                        </button>
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="bi bi-trash"></i> Sí, Eliminar
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>

                        <script>
                            $(function() {
                                $("#example1").DataTable({
                                    "pageLength": 10,
                                    "language": {
                                        "emptyTable": "No hay informacion",
                                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Roles",
                                        "infoEmpty": "Mostrando 0 a 0 de 0 Roles",
                                        "infoFiltered": "(Filtrado de _MAX_ total Roles)",
                                        "infoPostFix": "",
                                        "thousands": ",",
                                        "lengthMenu": "Mostrar _MENU_ Roles",
                                        "loadingRecords": "Cargando...",
                                        "processing": "Procesando...",
                                        "search": "Buscador:",
                                        "zeroRecords": "Sin resultados encontrados",
                                        "paginate": {
                                            "first": "Primero",
                                            "last": "Ultimo",
                                            "next": "Siguiente",
                                            "previous": "Anterior"
                                        }
                                    },
                                    "responsive": true,
                                    "lengthChange": true,
                                    "autoWidth": false,
                                    buttons: [{
                                            extend: 'collection',
                                            text: 'Reportes',
                                            orientacion: 'landscape',
                                            buttons: [{
                                                text: 'Copiar',
                                                extend: 'copy',
                                            }, {
                                                extend: 'pdf'
                                            }, {
                                                extend: 'csv'
                                            }, {
                                                extend: 'excel'
                                            }, {
                                                text: 'Imprimir',
                                                extend: 'print'
                                            }]
                                        },
                                        {
                                            extend: 'colvis',
                                            text: 'Visor de columnas',
                                            collectionLayout: 'fixed three-column'
                                        }
                                    ],
                                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Crear Rol -->
    <div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="createRoleModalLabel">
                        Crear Nuevo Rol
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nombre del Rol <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Ej: Administrador, Editor, Usuario" required>
                            <small class="form-text text-muted">El nombre debe ser único</small>
                        </div>

                        <div class="form-group">
                            <label>Permisos disponibles</label>
                            <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                @foreach ($permisos as $permission)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            id="permission-create-{{ $permission->id }}" name="permissions[]"
                                            value="{{ $permission->name }}">
                                        <label class="form-check-label" for="permission-create-{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <small class="form-text text-muted">Selecciona los permisos que tendrá este rol</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Crear Rol
                        </button>
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
