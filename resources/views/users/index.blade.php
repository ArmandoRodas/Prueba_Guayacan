@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
  <h1>Usuarios</h1>
@stop

@section('content')
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <form class="row g-2 mb-3" method="GET" action="{{ route('users.index') }}">
    <div class="col-md-4">
      <input type="text" name="q" class="form-control" placeholder="Buscar por nombre, email o teléfono" value="{{ $q }}">
    </div>
    <div class="col-md-3">
      <select name="role" class="form-select">
        <option value="">— Rol —</option>
        <option value="technician" {{ $role==='technician'?'selected':'' }}>Técnico</option>
        <option value="admin" {{ $role==='admin'?'selected':'' }}>Admin</option>
        <option value="frontdesk" {{ $role==='frontdesk'?'selected':'' }}>Recepción</option>
      </select>
    </div>
    <div class="col-md-3">
      <select name="state" class="form-select">
        <option value="">— Estado —</option>
        <option value="active" {{ $state==='active'?'selected':'' }}>Activo</option>
        <option value="inactive" {{ $state==='inactive'?'selected':'' }}>Inactivo</option>
      </select>
    </div>
    <div class="col-md-2">
      <button class="btn btn-outline-primary w-100">Filtrar</button>
    </div>
  </form>

  <div class="mb-3">
    <a href="{{ route('users.create') }}" class="btn btn-primary">Nuevo usuario</a>
  </div>

  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Rol</th>
            <th>Estado</th>
            <th style="width:160px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($users as $u)
          <tr>
            <td>{{ $u->id }}</td>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->phone }}</td>
            <td>
              @switch($u->role)
                @case('technician') Técnico @break
                @case('admin') Admin @break
                @case('frontdesk') Recepción @break
              @endswitch
            </td>
            <td>
              <span class="badge {{ $u->is_active ? 'bg-success' : 'bg-secondary' }}">
                {{ $u->is_active ? 'Activo' : 'Inactivo' }}
              </span>
            </td>
            <td>
              <a href="{{ route('users.edit', $u) }}" class="btn btn-sm btn-warning">Editar</a>
              <form action="{{ route('users.destroy', $u) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('¿Eliminar este usuario?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger">Eliminar</button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="7">No hay usuarios.</td></tr>
          @endforelse
        </tbody>
      </table>

      <div class="mt-2">
        {{ $users->links() }}
      </div>
    </div>
  </div>
@stop
