<div class="row padding-1 p-1">
    <div class="col-md-12">

        <div class="form-group mb-2 mb20">
            <label for="fecha_salida" class="form-label">Fecha y Hora de la Salida del Funcionario Policial</label>
            <input type="datetime-local" name="fecha_salida" class="form-control @error('fecha_salida') is-invalid @enderror" value="{{ old('fecha_salida', $asistenciasalida?->fecha_salida) }}" id="fecha_salida" placeholder="Fecha Salida">
            {!! $errors->first('fecha_salida', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="motivo_salida" class="form-label">Motivo de la Salida del Funcionario Policial</label>
            <input type="text" name="motivo_salida" class="form-control @error('motivo_salida') is-invalid @enderror" value="{{ old('motivo_salida', $asistenciasalida?->motivo_salida) }}" id="motivo_salida" placeholder="Describa Motivo Salida">
            {!! $errors->first('motivo_salida', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="miembro_id" class="form-label">Nombre y Apellido Funcionario Policial</label>
            <select name="miembro_id" class="form-control">
                <option value="" disabled selected>Seleccionar Funcionario Policial</option> <!-- Placeholder -->
                @foreach($miembros as $id => $nombre)
                <option value="{{$id}}" {{$asistenciasalida->miembro_id == $id? 'selected' : '' }}>
                    {{$nombre}}
                </option>
                @endforeach
            </select>

            <!-- <input type="text" name="miembro_id" class="form-control @error('miembro_id') is-invalid @enderror" value="{{ old('miembro_id', $asistenciasalida?->miembro_id) }}" id="miembro_id" placeholder="Miembro Id">-->
            {!! $errors->first('miembro_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="asistencia_id" class="form-label">Fecha y Hora de Ingreso del Funcionario Policial</label>
            <select name="asistencia_id" class="form-control">
            <option value="" disabled selected>Selecciona Fecha de Ingreso del Funcionario Policial</option> <!-- Placeholder -->
                @foreach($asistencias as $id => $nombresito)
                <option value="{{$id}}" {{$asistenciasalida->asistencia_id == $id? 'selected' : '' }}>
                    {{$nombresito}}
                </option>
                @endforeach
            </select>
            <!--<input type="text" name="asistencia_id" class="form-control @error('asistencia_id') is-invalid @enderror" value="{{ old('asistencia_id', $asistenciasalida?->asistencia_id) }}" id="asistencia_id" placeholder="Asistencia Id">-->

            {!! $errors->first('asistencia_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">Guardar Marcado de Asistencia de Salida</button>
    </div>
</div>