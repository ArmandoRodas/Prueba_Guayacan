@extends('adminlte::page')

@section('title', 'Edit Device Type')

@section('content_header')
  <h1>Editar Tipo de Equipo</h1>
@stop

@section('content')
  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('device-types.update', $deviceType) }}">
        @csrf @method('PUT')
        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input type="text" name="name" class="form-control" maxlength="60"
                 value="{{ old('name', $deviceType->name) }}" required>
          @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
        <a href="{{ route('device-types.index') }}" class="btn btn-secondary">Regresar</a>
        <button class="btn btn-primary">Actualizar</button>
      </form>
    </div>
  </div>
@stop
