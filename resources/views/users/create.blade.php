@extends('adminlte::page')

@section('title', 'Nuevo usuario')

@section('content_header')
  <h1>Nuevo usuario</h1>
@stop

@section('content')
<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('users.store') }}">
      @csrf

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Nombre *</label>
          <input type="text" name="name" class="form-control" maxlength="120" value="{{ old('name') }}" required>
          @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Correo electrónico</label>
          <input type="email" name="email" class="form-control" maxlength="190" value="{{ old('email') }}">
          @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
          <label class="form-label">Teléfono</label>
          <input type="text" name="phone" class="form-control" maxlength="30" value="{{ old('phone') }}">
          @error('phone') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
          <label class="form-label">Rol *</label>
          <select name="role" class="form-select" required>
            <option value="">— Seleccionar —</option>
            <option value="technician" {{ old('role')==='technician'?'selected':'' }}>Técnico</option>
            <option value="admin" {{ old('role')==='admin'?'selected':'' }}>Admin</option>
            <option value="frontdesk" {{ old('role')==='frontdesk'?'selected':'' }}>Recepción</option>
          </select>
          @error('role') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
          <div class="form-check mt-4">
            <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                   {{ old('is_active', true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Activo</label>
          </div>
        </div>
      </div>

      <a href="{{ route('users.index') }}" class="btn btn-secondary">Regresar</a>
      <button class="btn btn-primary">Guardar</button>
    </form>
  </div>
</div>
@stop
