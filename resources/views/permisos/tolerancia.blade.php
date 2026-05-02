@extends('layouts.admin')

@section('content')
<div class="content" style="margin-left: 20px">
    <h1 class="mb-4">Configuración de Tolerancias</h1>

    <div class="row">
        <div class="col-md-8">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><b>Tolerancias del Sistema</b></h3>
                </div>

                <div class="card-body">

                    <form action="{{ route('guardar_tolerancia') }}" method="POST">
                        @csrf

                        {{--  COMPONENTE DE CAMPO  --}}
                        @php
                            function campo($id, $label, $desc, $value) {
                                return "
                                <div class='form-group mb-4'>
                                    <label for='{$id}'><b>{$label}</b></label>
                                    <div class='d-flex align-items-center mt-1'>
                                        <small class='text-muted flex-grow-1' style='max-width:75%'>
                                            {$desc}
                                        </small>
                                        <input type='time' name='{$id}' id='{$id}'
                                            class='form-control ml-3'
                                            style='max-width:130px'
                                            value='{$value}' required>
                                    </div>
                                </div>
                                ";
                            }
                        @endphp

                        {!! campo(
                            'atraso_por_minuto',
                            'Atraso por minuto',
                            'Tiempo mínimo permitido antes de que el sistema registre una falta.',
                            $tolerancia->atraso_por_minuto ?? ''
                        ) !!}

                        {!! campo(
                            'salida_anticipada',
                            'Salida anticipada',
                            'Minutos antes de la hora de salida que ya cuenta como salida anticipada.',
                            $tolerancia->salida_anticipada ?? ''
                        ) !!}

                        {!! campo(
                            'tolerancia_maxima_entrada',
                            'Tolerancia máxima de entrada',
                            'Tiempo extra que se permite al ingresar sin marcar atraso real.',
                            $tolerancia->tolerancia_maxima_entrada ?? ''
                        ) !!}

                        {!! campo(
                            'maximo_salida',
                            'Máximo de salida',
                            'Hora máxima para registrar la salida antes de tomarlo como infracción.',
                            $tolerancia->maximo_salida ?? ''
                        ) !!}

                        {!! campo(
                            'antelacion_marcado',
                            'Antelación de marcado',
                            'Cuánto antes puede marcar la entrada sin que el sistema la rechace.',
                            $tolerancia->antelacion_marcado ?? ''
                        ) !!}

                        {!! campo(
                            'antelacion_salida',
                            'Antelación de salida',
                            'Cuánto antes puede marcar la salida sin contar como salida anticipada.',
                            $tolerancia->antelacion_salida ?? ''
                        ) !!}

                        <button type="submit" class="btn btn-success btn-block mt-3">
                            <i class="bi bi-cloud-check"></i> Guardar configuración
                        </button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if (session('success'))
Swal.fire({
    icon: 'success',
    title: '¡Listo!',
    text: '{{ session('success') }}',
});
@endif
</script>
@endsection
