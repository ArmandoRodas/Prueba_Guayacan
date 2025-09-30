@extends('adminlte::page')

@section('title', 'New Device Type')

@section('content_header')
  <h1>Nuevo tipo de Equipo</h1>
@stop

@section('content')
  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('device-types.store') }}">
        @csrf
        <div class="mb-3">
          <label class="form-label">Nombre del equipo</label>
          <input type="text" name="name" class="form-control" maxlength="60" value="{{ old('name') }}" required>
          @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
        <a href="{{ route('device-types.index') }}" class="btn btn-secondary">Regresar</a>
        <button class="btn btn-primary">Guardar</button>
      </form>
    </div>
  </div>
@stop
