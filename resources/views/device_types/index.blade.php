@extends('adminlte::page')

@section('title', 'Device Types')

@section('content_header')
  <h1>Tipos de Equipo</h1>
@stop

@section('content')
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="mb-3">
    <a href="{{ route('device-types.create') }}" class="btn btn-primary">Nuevo tipo de Equipo</a>
  </div>

  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Nombre</th>
            <th style="width:140px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($deviceTypes as $t)
            <tr>
              <td>{{ $t->id }}</td>
              <td>{{ $t->name }}</td>
              <td>
                <a href="{{ route('device-types.edit', $t) }}" class="btn btn-sm btn-warning">Editar </a>
                <form action="{{ route('device-types.destroy', $t) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Eliminar este tipo de Equipo?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger">Eliminar</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="3">Sin registros...</td></tr>
          @endforelse
        </tbody>
      </table>

      <div class="mt-2">
        {{ $deviceTypes->links() }}
      </div>
    </div>
  </div>
@stop

