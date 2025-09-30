@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
  <h1>Clientes</h1>
@stop

@section('content')
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="d-flex justify-content-between align-items-center mb-3">
    <form class="d-flex" method="GET" action="{{ route('clients.index') }}">
      <input type="text" name="q" class="form-control me-2" placeholder="Buscar por nombre, NIT, email o teléfono"
             value="{{ $q }}">
      <button class="btn btn-outline-primary">Buscar</button>
    </form>
    <a href="{{ route('clients.create') }}" class="btn btn-primary">Nuevo cliente</a>
  </div>

  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>NIT / Documento</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Dirección</th>
            <th style="width:160px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($clients as $c)
          <tr>
            <td>{{ $c->id }}</td>
            <td>{{ $c->first_name }}</td>
            <td>{{ $c->last_name }}</td>
            <td>{{ $c->tax_id }}</td>
            <td>{{ $c->phone }}</td>
            <td>{{ $c->email }}</td>
            <td>{{ $c->address }}</td>
            <td>
              <a href="{{ route('clients.edit', $c) }}" class="btn btn-sm btn-warning">Editar</a>
              <form action="{{ route('clients.destroy', $c) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('¿Eliminar este cliente?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger">Eliminar</button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="8">No hay registros.</td></tr>
          @endforelse
        </tbody>
      </table>

      <div class="mt-2">
        {{ $clients->links() }}
      </div>
    </div>
  </div>
@stop
