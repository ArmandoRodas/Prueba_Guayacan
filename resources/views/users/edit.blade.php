@extends('adminlte::page')

@section('title', 'Editar usuario')

@section('content_header')
  <h1>Editar usuario</h1>
@stop

@section('content')
<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('users.update', $user) }}">
      @csrf @method('PUT')

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Nombre *</label>
          <input type="text" name="name" class="form-control" maxlength="120"
                 value="{{ old('name', $user->name) }}" required>
          @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Correo electrónico</label>
          <input type="email" name="email" class="form-control" maxlength="190"
                 value="{{ old('email', $user->email) }}">
          @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
          <label class="form-label">Teléfono</label>
          <input type="text" name="phone" class="form-control" maxlength="30"
                 value="{{ old('phone', $user->phone) }}">
          @error('phone') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
          <label class="form-label">Rol *</label>
          <select name="role" class="form-select" required>
            <option value="technician" {{ old('role', $user->role)==='technician'?'selected':'' }}>Técnico</option>
            <option value="admin" {{ old('role', $user->role)==='admin'?'selected':'' }}>Admin</option>
            <option value="frontdesk" {{ old('role', $user->role)==='frontdesk'?'selected':'' }}>Recepción</option>
          </select>
          @error('role') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
          <div class="form-check mt-4">
            <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                   {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Activo</label>
          </div>
        </div>
      </div>

      <a href="{{ route('users.index') }}" class="btn btn-secondary">Regresar</a>
      <button class="btn btn-primary">Actualizar</button>
    </form>
  </div>
</div>
@stop
