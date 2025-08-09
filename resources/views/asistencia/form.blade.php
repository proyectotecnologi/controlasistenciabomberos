<div class="row padding-1 p-1">
    <div class="col-md-8">

        <div class="form-group mb-2 mb20">
            <label for="fecha" class="form-label">Fecha y Hora de Asistencia Ingreso</label>
            <input type="datetime-local" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha', $asistencia?->fecha) }}" id="fecha" placeholder="Fecha">
            {!! $errors->first('fecha', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="miembro_id" class="form-label">Nombre y Apellido del Funcionario Policial</label>
            <select name="miembro_id" class="form-control">
            <option value="" disabled selected>Seleccionar Nombre y Apellido</option> <!-- Placeholder -->
                @foreach($miembros as $id => $nombre)
                <option value="{{$id}}" {{$asistencia->miembro_id == $id? 'selected' : '' }}>
                    {{$nombre}}
                </option>
                @endforeach
            </select>
            {!!$errors->first('miembro_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">Guardar Marcado de asistencia Hora de Ingreso</button>
    </div>
</div>


<!--<div class="form-group mb-2 mb20">
    <label for="miembro_id" class="form-label">{{ __('Miembro Id') }}</label>
    <input type="select" name="miembro_id" , $miembros, class="form-control @error('miembro_id') is-invalid @enderror" value="{{ old('miembro_id', $asistencia?->miembro_id) }}" id="miembro_id" placeholder="Miembro Id">
    {!! $errors->first('miembro_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
</div>-->