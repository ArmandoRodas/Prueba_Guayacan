@extends('adminlte::page')

@section('title', 'Nuevo equipo')

@section('content_header')
  <h1>Nuevo equipo</h1>
@stop

@section('content')
<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('devices.store') }}">
      @csrf

      <div class="row">
        <div class="col-md-4 mb-3">
          <label class="form-label">Cliente *</label>
          <select name="client_id" class="form-select" required>
            <option value="">— Seleccionar —</option>
            @foreach($clients as $c)
              <option value="{{ $c->id }}" {{ old('client_id')==$c->id?'selected':'' }}>
                {{ trim($c->first_name.' '.$c->last_name) }}
              </option>
            @endforeach
          </select>
          @error('client_id') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
          <label class="form-label">Tipo de equipo *</label>
          <select name="device_type_id" class="form-select" required>
            <option value="">— Seleccionar —</option>
            @foreach($deviceTypes as $t)
              <option value="{{ $t->id }}" {{ old('device_type_id')==$t->id?'selected':'' }}>{{ $t->name }}</option>
            @endforeach
          </select>
          @error('device_type_id') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
          <label class="form-label">Marca</label>
          <select name="brand_id" class="form-select">
            <option value="">— (Opcional) —</option>
            @foreach($brands as $b)
              <option value="{{ $b->id }}" {{ old('brand_id')==$b->id?'selected':'' }}>{{ $b->name }}</option>
            @endforeach
          </select>
          @error('brand_id') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
          <label class="form-label">Modelo</label>
          <input type="text" name="model" class="form-control" maxlength="120" value="{{ old('model') }}">
          @error('model') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
          <label class="form-label">Número de serie</label>
          <input type="text" name="serial_number" class="form-control" maxlength="120" value="{{ old('serial_number') }}">
          @error('serial_number') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
          <label class="form-label">IMEI</label>
          <input type="text" name="imei" class="form-control" maxlength="20" value="{{ old('imei') }}">
          @error('imei') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-12 mb-3">
          <label class="form-label">Accesorios</label>
          <input type="text" name="accessories" class="form-control" maxlength="255" value="{{ old('accessories') }}">
          @error('accessories') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-12 mb-3">
          <label class="form-label">Notas</label>
          <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
          @error('notes') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
      </div>

      <a href="{{ route('devices.index') }}" class="btn btn-secondary">Regresar</a>
      <button class="btn btn-primary">Guardar</button>
    </form>
  </div>
</div>
@stop
