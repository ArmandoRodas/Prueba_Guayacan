@extends('adminlte::page')

@section('title', 'Estados de servicio')

@section('content_header')
  <h1>Estados de servicio</h1>
@stop

@section('content')
  @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
  @if(session('error'))   <div class="alert alert-danger">{{ session('error') }}</div>   @endif

  <form class="row g-2 mb-3" method="GET" action="{{ route('service-statuses.index') }}">
    <div class="col-md-8">
      <input type="text" name="q" class="form-control" placeholder="Buscar por código o nombre" value="{{ $q }}">
    </div>
    <div class="col-md-2">
      <button class="btn btn-outline-primary w-100">Buscar</button>
    </div>
    <div class="col-md-2 text-end">
      <a href="{{ route('service-statuses.create') }}" class="btn btn-primary w-100">Nuevo estado</a>
    </div>
  </form>

  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Final</th>
            <th style="width:160px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($statuses as $s)
            <tr>
              <td><code>{{ $s->code }}</code></td>
              <td>{{ $s->label }}</td>
              <td>
                <span class="badge {{ $s->is_final ? 'bg-success' : 'bg-secondary' }}">
                  {{ $s->is_final ? 'Sí' : 'No' }}
                </span>
              </td>
              <td>
                <a href="{{ route('service-statuses.edit', $s) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('service-statuses.destroy', $s) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('¿Eliminar este estado?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger">Eliminar</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="4">No hay estados.</td></tr>
          @endforelse
        </tbody>
      </table>

      <div class="mt-2">
        {{ $statuses->links() }}
      </div>
    </div>
  </div>
@stop
