@extends('adminlte::page')

@section('title', 'Editar equipo')

@section('content_header')
  <h1>Editar equipo</h1>
@stop

@section('content')
<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('devices.update', $device) }}">
      @csrf @method('PUT')

      <div class="row">
        <div class="col-md-4 mb-3">
          <label class="form-label">Cliente *</label>
          <select name="client_id" class="form-select" required>
            @foreach($clients as $c)
              <option value="{{ $c->id }}" {{ old('client_id', $device->client_id)==$c->id?'selected':'' }}>
                {{ trim($c->first_name.' '.$c->last_name) }}
              </option>
            @endforeach
          </select>
          @error('client_id') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
          <label class="form-label">Tipo de equipo *</label>
          <select name="device_type_id" class="form-select" required>
            @foreach($deviceTypes as $t)
              <option value="{{ $t->id }}" {{ old('device_type_id', $device->device_type_id)==$t->id?'selected':'' }}>
                {{ $t->name }}
              </option>
            @endforeach
          </select>
          @error('device_type_id') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
          <label class="form-label">Marca</label>
          <select name="brand_id" class="form-select">
            <option value="">— (Opcional) —</option>
            @foreach($brands as $b)
              <option value="{{ $b->id }}" {{ old('brand_id', $device->brand_id)==$b->id?'selected':'' }}>
                {{ $b->name }}
              </option>
            @endforeach
          </select>
          @error('brand_id') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
          <label class="form-label">Modelo</label>
          <input type="text" name="model" class="form-control" maxlength="120"
                 value="{{ old('model', $device->model) }}">
          @error('model') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
          <label class="form-label">Número de serie</label>
          <input type="text" name="serial_number" class="form-control" maxlength="120"
                 value="{{ old('serial_number', $device->serial_number) }}">
          @error('serial_number') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
          <label class="form-label">IMEI</label>
          <input type="text" name="imei" class="form-control" maxlength="20"
                 value="{{ old('imei', $device->imei) }}">
          @error('imei') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-12 mb-3">
          <label class="form-label">Accesorios</label>
          <input type="text" name="accessories" class="form-control" maxlength="255"
                 value="{{ old('accessories', $device->accessories) }}">
          @error('accessories') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-12 mb-3">
          <label class="form-label">Notas</label>
          <textarea name="notes" class="form-control" rows="3">{{ old('notes', $device->notes) }}</textarea>
          @error('notes') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
      </div>

      <a href="{{ route('devices.index') }}" class="btn btn-secondary">Regresar</a>
      <button class="btn btn-primary">Actualizar</button>
    </form>
  </div>
</div>
@stop
