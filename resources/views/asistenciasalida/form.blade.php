<div class="row padding-1 p-1">
    <div class="col-md-12">

        <!--<div class="form-group mb-2 mb20">
            <label for="fecha_salida" class="form-label">{{ __('Fecha Salida') }}</label>
            <input type="text" name="fecha_salida" class="form-control @error('fecha_salida') is-invalid @enderror" value="{{ old('fecha_salida', $asistenciasalida?->fecha_salida) }}" id="fecha_salida" placeholder="Fecha Salida">
            {!! $errors->first('fecha_salida', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="motivo_salida" class="form-label">{{ __('Motivo Salida') }}</label>
            <input type="text" name="motivo_salida" class="form-control @error('motivo_salida') is-invalid @enderror" value="{{ old('motivo_salida', $asistenciasalida?->motivo_salida) }}" id="motivo_salida" placeholder="Motivo Salida">
            {!! $errors->first('motivo_salida', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="miembro_id" class="form-label">{{ __('Miembro Id') }}</label>
            <input type="text" name="miembro_id" class="form-control @error('miembro_id') is-invalid @enderror" value="{{ old('miembro_id', $asistenciasalida?->miembro_id) }}" id="miembro_id" placeholder="Miembro Id">
            {!! $errors->first('miembro_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>-->

        <div class="form-group mb-2 mb20">
            <label for="fecha_salida" class="form-label">Fecha Salida</label>
            <input type="datetime-local" name="fecha_salida" class="form-control @error('fecha_salida') is-invalid @enderror" value="{{ old('fecha_salida', $asistenciasalida?->fecha_salida) }}" id="fecha_salida" placeholder="Fecha Salida">
            {!! $errors->first('fecha_salida', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="motivo_salida" class="form-label">{{ __('Motivo Salida') }}</label>
            <input type="text" name="motivo_salida" class="form-control @error('motivo_salida') is-invalid @enderror" value="{{ old('motivo_salida', $asistenciasalida?->motivo_salida) }}" id="motivo_salida" placeholder="Describa Motivo Salida">
            {!! $errors->first('motivo_salida', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="miembro_id" class="form-label">Miembros</label>
            <select name="miembro_id" class="form-control">
            <option value="" disabled selected>Selecciona un miembro</option> <!-- Placeholder -->
                @foreach($miembros as $id => $nombre)
                <option value="{{$id}}" {{$asistenciasalida->miembro_id == $id? 'selected' : '' }}>
                    {{$nombre}} <br><br> {{$id}}
                </option>
                @endforeach
            </select>
            {!!$errors->first('miembro_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</div>